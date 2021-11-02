<?php


namespace App\Http\Controllers\Admin\Accounting;


use App\Models\Client;
use App\Models\Estimation;
use App\Repository\ClientRepository;
use App\Repository\EstimationDetailRepository;
use App\Repository\EstimationRepository;
use Fpdf\Fpdf;

class EstimationCreatePDF extends Fpdf
{

    private $getClient;

    private $getEstimation;

    private $total;

    /**
     * EstimationCreatePDFAction constructor.
     *
     * @param ClientRepository $clientRepository
     * @param EstimationRepository $estimationRepository
     * @param EstimationDetailRepository $estimationDetailRepository
     */
    public function __construct(
        private ClientRepository $clientRepository,
        private EstimationRepository $estimationRepository,
        private EstimationDetailRepository $estimationDetailRepository
    ) { parent::__construct('P', 'cm', 'A4'); }

    /**
     * @param $slug
     * @param $id
     */
    private function getData($slug, $id): void
    {
        $this->getEstimation = $this->estimationRepository->getOneWithAllRelationsById($id);
        $this->getClient = $this->clientRepository->getOneBySlugWithAllRelations($slug);
        $this->total = $this->estimationDetailRepository->getTotalByIdEstimation($id);
    }

    private function newPage()
    {
        if ($this->GetY() >= 18) {
            $this->AddPage();
            $this->imageHeader();
            $this->SetFont('aristabold', '', 14);
            $this->Cell(17,1,utf8_decode('Description'));
            $this->Cell(4,1,'PV HT');
            $this->SetFont('aristalight', '', 14);
            $this->SetY($this->GetY()+1);
            $y = $this->GetY();
            $this->SetDrawColor(255, 254,0);
            $this->SetLineWidth(.07);
            $this->Line(1.1, $y, 19.3, $y);
            $this->SetDrawColor(0, 0, 0);
            $this->SetY($this->GetY()+.5);
        }
    }

    private function imageHeader()
    {
        $this->Image(base_path('public/images/logo-mout-factures.png'), 0, 0, 21, 3.7);
        $this->SetY(4.3);
    }

    public function entete()
    {
        $lineHeight = .6;

        $this->AddFont('aristalight', '', 'aristalight.php');
        $this->AddFont('aristaregular', '', 'aristaregular.php');
        $this->AddFont('aristabold', '', 'aristabold.php');
        $this->AddPage();
        $this->SetFont('aristalight','',14);
        $this->imageHeader();
        $this->Cell(3.5,1, utf8_decode('Devis référence : '));
        $this->SetFont('aristabold', '', 14);
        $this->Cell(3,1, utf8_decode($this->getEstimation->reference));
        $this->SetFont('aristalight', '', 14);
        $this->SetX(12);
        $this->Cell(4, 1, utf8_decode('Fait à le Chesnay le ' . $this->getEstimation->created_at->format('d/m/Y')), 0, 2);
        $y = $this->GetY();
        $this->SetXY(1, $y);
        $this->SetDrawColor(255, 254,0);
        $this->SetLineWidth(.07);
        $this->Line(1.1, $y, 6.9, $y);
        $this->SetDrawColor(0, 0, 0);
        $y = $this->getY();
        $this->SetY(5.7);
        $this->SetFont('aristaregular', '', 14);
        $this->Cell(4, 1, utf8_decode($this->getClient->name));
        $this->SetFont('aristalight');
        $y = $this->GetY();
        $this->SetXY(1, $y+$lineHeight);
        $this->Cell(4, 1, utf8_decode($this->getClient->address));
        $this->SetXY(1, 6.9);
        $this->Cell(10, 1, utf8_decode($this->getClient->zip . ' ' . $this->getClient->city));
        $y = $this->GetY();
        $this->SetXY(1, $y+$lineHeight);
        $this->Cell(10, 1, utf8_decode('N° SIRET : ' . $this->getClient->siret));
        $y = $this->GetY();
        $this->SetXY(1, $y+$lineHeight);
        $this->Cell(14, 1, utf8_decode('N° TVA Intra-communautaire : ' . $this->getClient->tvaintracommunautaire));
        $y = $this->GetY();
        $this->SetXY(1, $y+$lineHeight);
        $this->Cell(10, 1, $this->getEstimation->user->email);
    }

    private function getDetails($estimation)
    {
        foreach($estimation->estimationDetails as $details)
        {
            $y = $this->GetY();
            $this->SetY($y+1);
            $this->newPage();
            $this->SetFont('aristabold', '', 14);
            $this->Cell(15, .7, utf8_decode($details->product));
            $this->Cell(3.5, .7, utf8_decode($details->total_row_notax).iconv('UTF-8', 'windows-1252', ' €'), 0, 0, 'R');
            $y = $this->GetY();
            $this->SetY($y+.7);
            $this->SetFont('aristalight', '', 14);
            $this->MultiCell(15, .7, utf8_decode($details->description));

        }
    }

    private function getTotal($estimation)
    {
        $this->SetY($this->GetY()+2);
        $y = $this->GetY();
        $this->SetDrawColor(255, 254,0);
        $this->SetLineWidth(.07);
        $this->Line(1.1, $y, 19.3, $y);
        $this->SetDrawColor(0, 0, 0);
        $this->SetY($this->GetY()+.4);
        $this->SetFont('aristabold', '', 14);
        $this->Cell(12, .7, utf8_decode('Conditions de paiement'));
        $this->Cell(3.5, .7, utf8_decode('Total HT'), '', 0, 'R');
        $this->Cell(3.5, .7, utf8_decode($this->total['total_row_notax']).iconv('UTF-8', 'windows-1252', ' €'), '', 0, 'R');
        $this->SetY($this->GetY()+.6);
        $this->SetFont('aristalight', '', 14);
        $this->Cell(12, .7, utf8_decode('Date et signature :'));
        $this->SetFont('aristabold', '', 14);
        $this->Cell(3.5, .7, utf8_decode('TVA'), '', 0, 'R');
        $this->Cell(3.5, .7, utf8_decode($this->total['total_row_tax']).iconv('UTF-8', 'windows-1252', ' €'), '', 0, 'R');
        $this->SetY($this->GetY()+.6);
        $this->Cell(15.5, .7, utf8_decode('Total TTC'), '', 0, 'R');
        $this->Cell(3.5, .7, utf8_decode($this->total['total_row']).iconv('UTF-8', 'windows-1252', ' €'), '', 0, 'R');
    }

    function Footer()
    {
        $this->SetFont('aristaregular', '', 10);
        $this->SetY(-3);
        $this->Cell(0,1,'MOUT',0,0,'C');
        $this->SetFont('aristalight', '', 8);
        $this->SetY(-2.6);
        $this->Cell(0,1,'moutwebagency.com',0,0,'C');
        $this->SetY(-2.2);
        $this->Cell(0,1,'06 62 45 10 36 / 06 70 06 11 07',0,0,'C');
        $this->SetY(-1.8);
        $this->Cell(0,1,'84 rue de Versailles / 78150 Le Chesnay',0,0,'C');
        $this->SetY(-1.4);
        $this->Cell(0,1,'SIREN : 842 793 648 / Code APE 6312Z',0,0,'C');
        $this->SetY(-1);
        $this->Cell(0,1, 'SAS au capital social de 2.000 '.iconv('UTF-8', 'windows-1252', '€'),0,0,'C');
    }

    public function create(Client $client, Estimation $estimation)
    {
        $this->getData($client->slug, $estimation->id);
        $this->entete();

        //Body
        $this->SetAutoPageBreak(true, 3);
        $this->SetY(6.5);
        $this->SetFont('aristabold', '', 14);
        $this->Cell(17,10,utf8_decode('Description'));
        $this->Cell(4,10,'PV HT');
        $this->SetFont('aristalight', '', 14);
        $this->SetY(12);
        $y = $this->GetY();
        $this->SetDrawColor(255, 254,0);
        $this->SetLineWidth(.07);
        $this->Line(1.1, $y, 19.3, $y);
        $this->SetDrawColor(0, 0, 0);
        $y = $this->getY();
        $this->SetY($y+.3);
        $this->SetFont('aristabold', '', 14);
        $this->Cell(20, 1, utf8_decode($estimation->title));

        $this->getDetails($estimation);

        $this->getTotal($estimation);

        $response = response($this->Output('I'));
        $response->header('Content-Type', 'application/pdf');

        return $response;

    }
}

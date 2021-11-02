<?php

namespace App\Console\Commands;

use App\Repository\ModuleRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ModuleManagement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modules:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init only new modules in app';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function verification($modelInstance)
    {
        if (!is_null($modelInstance->module)) {

            if(!array_key_exists('name', $modelInstance->module)) {

                $modelInstance->module['classname'] = class_basename($modelInstance);
            }

            return true;
        } else {
            return false;
        }

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = app_path('Models');
        //Je récupères tous les modèles
        $files = File::files($path);

        $permissionsRepository = app(config('modules.permissionsRepository'));
        $modulesRepository = app(config('modules.modulesRepository'));
        //TODO: VERIFIER SI LE MODULE EXISTE EN BDD

        foreach ($files as $modelFile) {
            $modelNamespace = '\App\\Models\\' . $modelFile->getFilenameWithoutExtension();

            //on veut vérifier la présence de modelnamespace dans le champ classname de la table module
            //Retourne l'objet module si trouvé, si non = null
            $findModule = app(config('modules.modulesRepository'))->getByClassName($modelFile->getFilenameWithoutExtension());

            //On initialise
            $model = new $modelNamespace();

            //On veut traiter les modules qui sont enregistrés en bdd
            if (!is_null($findModule)) {
                //on vérifie si l'entité est toujours un module
                if ($this->verification($model) == true) {
                    //on met à jour le module
                    $modulesRepository->update($model, $findModule);

                    //on gère les permissions
                    //Si le module existe mais qu'il n'y a plus de permissions
                    if (!isset($model->permissions)) {
                        $permissionsRepository->destroy($findModule);
                    } else {
                        //sinon on met à jour les permissions
                        $permissionsRepository->update($model->permissions, $findModule);
                    }

                } else {
                    //on supprime le module de la bdd ET par héritage SES permissions
                    $modulesRepository->destroy($findModule);
                }

            } else {
                //on est sur une nouvelle entité
                //on vérifie si c'est un nouveau module
                if ($this->verification($model) == true) {
                    //L'entité est un module ET n'existe pas en bdd, il faut le créer
                    $newModule = $modulesRepository->store($model);

                    //On enregistre les permissions. Le controle des permissions complémentaires (hors CRUD) est réalisée dans le repo
                    $permissionsRepository->store($model, $newModule);
                }
            }
        }
        return 0;
    }
}

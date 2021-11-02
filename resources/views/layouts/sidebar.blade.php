<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="{{ route('homeAdmin') }}" class="waves-effect">
                        <span key="t-dashboards">@lang('translation.Dashboards')</span>
                    </a>
                </li>

                <li class="menu-title" key="t-apps">Modules</li>

                <li>
                    @can('show.client')
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-factures">Clients</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('clients.index') }}" key="t-clients-list">Voir tous</a></li>
                        <li><a href="{{ route('clients.create') }}" key="t-clients-create">Créer nouveau</a>
                        </li>
                    </ul>
                    @endcan
                    @can('show.one.client')
                        <a href="{{ route('clients.show', auth()->user()->client->slug) }}" class="waves-effect">
                            <i class="bx bxs-user-detail"></i>
                            <span key="t-factures">{{ auth()->user()->client->name }}</span>
                        </a>
                    @endcan
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-briefcase-alt-2"></i>
                        <span key="t-dashboards">Projets</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('projects.index') }}" key="t-project-list">Voir tous</a></li>
                        <li><a href="{{ route('projects.create') }}" key="t-project-create">Créer nouveau</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-receipt"></i>
                        <span key="t-invoices">Devis</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('estimations.index') }}" key="t-invoice-list">Voir tous</a></li>
                        <li><a href="{{ route('estimations.create') }}" key="t-invoice-create">Créer nouveau</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('invoices.index') }}" class="waves-effect">
                        <i class="bx bx-receipt"></i>
                        <span key="t-invoices">Factures</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span key="t-module">Modules</span>
                    </a>
                </li>

                <li>
                    <a href="chat" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span key="t-chat">@lang('translation.Chat')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-task"></i>
                        <span key="t-tasks">@lang('translation.Tasks')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="tasks-list" key="t-task-list">@lang('translation.Task_List')</a></li>
                        <li><a href="tasks-kanban" key="t-kanban-board">@lang('translation.Kanban_Board')</a></li>
                        <li><a href="tasks-create" key="t-create-task">@lang('translation.Create_Task')</a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->

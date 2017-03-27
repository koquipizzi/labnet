<?php
use mdm\admin\components\Helper; 
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    ['label' => 'Pacientes', 'icon' => 'fa fa-person', 'url' => ['/paciente']],
                    ['label' => 'Médicos', 'icon' => 'fa fa-person', 'url' => ['/medico']],
                    ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Same tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

     <ul class="sidebar-menu">
        
        <!-- Start category apps -->
        <li class="sidebar-category">
            <span>Laboratorio</span>
            <span class="pull-right"><i class="fa fa-trophy"></i></span>
        </li>
        <!--/ End category apps -->

<!--        <li class="submenu <?= (Yii::$app->controller->id == 'blog') ? 'active' : '' ?>">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-globe"></i></span>
                <span class="text">Pendientes</span>            
            </a>
        </li> -->
        <?php use yii\helpers\Url; ?> 
        <li class="submenu <?= (Yii::$app->controller->id == 'blog') ? 'active' : '' ?>">
            <a href="<?= Url::to(['/paciente/buscar','new' => 1]) ?>" >
                <span class="icon"><i class="fa fa-server"></i></span>
                <span class="text">Nuevo Protocolo</span>            
            </a>
        </li> 
        <!-- Start navigation - blog -->

        
                <!-- Start navigation - blog -->
        <li class="submenu <?= (Yii::$app->controller->id == 'blog') ? 'active' : '' ?>">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-medkit"></i></span>
                <span class="text">Protocolos</span>
                <span class="arrow"></span>
                <?= (Yii::$app->controller->id == 'blog') ? '<span class="selected"></span>' : '' ?>
            </a>
            <ul>
                <li class="<?= (Yii::$app->controller->action->id == 'grid') ? 'active' : '' ?>">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('/protocolo') ?>">Activos</a>
                </li>
                <li class="<?= (Yii::$app->controller->action->id == 'list') ? 'active' : '' ?>">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('/protocolo/asignados') ?>">Asignados a mí</a>
                </li>
                <li class="<?= (Yii::$app->controller->action->id == 'list') ? 'active' : '' ?>">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('/protocolo/terminados') ?>">Terminados</a>
                </li>
                <li class="<?= (Yii::$app->controller->action->id == 'list') ? 'active' : '' ?>">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('/protocolo/entregados') ?>">Entregados</a>
                </li>                
                <li class="<?= (Yii::$app->controller->action->id == 'list') ? 'active' : '' ?>">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('/protocolo/all') ?>">Todos</a>
                </li>                
            </ul>
        </li>
        <!--/ End navigation - blog -->

        <!-- Start navigation - personas -->
        <li class="submenu <?= (Yii::$app->controller->id == 'mail') ? 'active' : '' ?>">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-group"></i></span>
                <span class="text">Personas</span>
                <span class="arrow"></span>
                <?= (Yii::$app->controller->id == 'mail') ? '<span class="selected"></span>' : '' ?>
            </a>
            <ul>
                </li>
                    <li class="<?= (Yii::$app->controller->action->id == 'single') ? 'active' : '' ?>">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('/paciente') ?>">Pacientes</a>
                </li>
                <li class="<?= (Yii::$app->controller->action->id == 'single') ? 'active' : '' ?>">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('/medico') ?>">Médicos</a>
                </li>              
                <li class="<?= (Yii::$app->controller->action->id == 'inbox') ? 'active' : '' ?>"><a href="<?= Yii::$app->getUrlManager()->createUrl('/user') ?>">Usuarios</a></li>
                <li class="<?= (Yii::$app->controller->action->id == 'compose') ? 'active' : '' ?>"><a href="<?= Yii::$app->getUrlManager()->createUrl('/admin/mail/compose') ?>">Administrativos</a></li>                           
                <li class="<?= (Yii::$app->controller->action->id == 'single') ? 'active' : '' ?>">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('/admin') ?>">Administrar Usuarios</a>
                </li>  
            </ul>
        </li>
        <!--/ End navigation - personas -->
         <!--/ End navigation - mail -->
        <?php //if(Helper::checkRoute('/pago/*')){?>
        <li class="submenu <?= (Yii::$app->controller->id == 'blog') ? 'active' : '' ?>">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-medkit"></i></span>
                <span class="text">Contable</span>
                <span class="arrow"></span>
                <?= (Yii::$app->controller->id == 'blog') ? '<span class="selected"></span>' : '' ?>
            </a>
            
                <ul>
                    <li class="<?= (Yii::$app->controller->action->id == 'grid') ? 'active' : '' ?>">
                        <a href="<?= Yii::$app->getUrlManager()->createUrl('/pago/index') ?>">Todos</a>
                    </li> 
                     <li class="<?= (Yii::$app->controller->action->id == 'grid') ? 'active' : '' ?>">
                        <a href="<?= Yii::$app->getUrlManager()->createUrl('/pago/impagos') ?>">Impagos</a>
                    </li> 
                     <li class="<?= (Yii::$app->controller->action->id == 'grid') ? 'active' : '' ?>">
                        <a href="<?= Yii::$app->getUrlManager()->createUrl('/pago/create') ?>">Nuevo Pago</a>
                    </li>                 
                </ul>
            
        </li>
         <?php //} ?>
        <!-- Start navigation - pages -->
        <li class="submenu <?= (Yii::$app->controller->id == 'page') ? 'active' : '' ?>">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-file-o"></i></span>
                <span class="text">Configuración</span>
                <span class="arrow"></span>
                <?= (Yii::$app->controller->id == 'page') ? '<span class="selected"></span>' : '' ?>
            </a>
            <ul>
                <li class="<?= (Yii::$app->controller->action->id == 'gallery') ? 'active' : '' ?>"><a href="<?= Yii::$app->getUrlManager()->createUrl('/nomenclador') ?>">Nomenclador</a></li>
                <li class="<?= (Yii::$app->controller->action->id == 'faq') ? 'active' : '' ?>"><a href="<?= Yii::$app->getUrlManager()->createUrl('/prestadoras') ?>">Coberturas</a></li>
                <li class="<?= (Yii::$app->controller->action->id == 'faq') ? 'active' : '' ?>"><a href="<?= Yii::$app->getUrlManager()->createUrl('/prestadoras/indexfacturable') ?>">Entidades Facturables </a></li>
                <li class="<?= (Yii::$app->controller->action->id == 'invoice') ? 'active' : '' ?>"><a href="<?= Yii::$app->getUrlManager()->createUrl('/procedencia') ?>">Procedencia</a></li>
                 <li class="<?= (Yii::$app->controller->action->id == 'invoice') ? 'active' : '' ?>"><a href="<?= Yii::$app->getUrlManager()->createUrl('/textos') ?>">AutoTextos</a></li>
                <li class="<?= (Yii::$app->controller->action->id == 'invoice') ? 'active' : '' ?>"><a href="<?= Yii::$app->getUrlManager()->createUrl('/localidad') ?>">Localidad</a></li>

                
                
                <?php $searchSubs = ['searchcourse']?>


       

    </ul><!-- /.sidebar-menu -->

</aside>

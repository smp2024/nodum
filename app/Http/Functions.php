<?php

    //Key Value From Json
    function kvfj($json, $key)
    {
        if($json == null):
            return null;
        else:
            $json = $json;
            $json = json_decode($json, true);
            if(array_key_exists($key, $json)):
                return $json[$key];
            else:
                return null;
            endif;
        endif;
    }

    function getModulesArray()
    {
        $a = [
            '0' => 'Products',
            '1' => 'Blog'
        ];

        return $a;
    }

    function getRoleUserArray($mode, $id)
    {

        $roles = ['0' => 'Usuario normal', '1' => 'Administrador'];
        if(!is_null($mode)):

            return $roles;

        else:

            return $roles[$id];

        endif;


    }

    function getUserStatusArray($mode, $id)
    {

        $status = ['0' => 'Registrado', '1' => 'Verificado', '100' => 'Baneado'];
        if(!is_null($mode)):

            return $status;

        else:

            return $status[$id];

        endif;

    }

    function getUserYears()
    {
        $ya = date('Y');
        $ym = $ya - 18;
        $yo = $ym - 62;

        return [$ym, $yo];
    }

    function getMonths($mode, $key)
    {
        $m = [
            '1' => 'Enero',
            '2' => 'Febrero',
            '3' => 'Marzo',
            '4' => 'Abril',
            '5' => 'Mayo',
            '6' => 'Juio',
            '7' => 'Julio',
            '8' => 'Agosto',
            '9' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];
        if($mode == 'list') {
            return $m;
        } else {
            return $m[$key];
        }


    }

    function user_permissions() {
        $p = [
            'dashboard' => [
                'icon' => '<i class="fal fa-tachometer-alt"></i>',
                'title' => 'Modulo Dashboard',
                'keys' => [
                    'dashboard' => 'Puede ver el dashboard',
                    'dashboard_small_stats' => 'Puede las estadísticas',
                ]
            ],

            'users_list' => [
                'icon' => '<i class="fal fa-users"></i>',
                'title' => 'Modulo Usuarios',
                'keys' => [
                    'users_list' => 'Puede ver el listado.',
                    'user_edit' => 'Puede editar.',
                    'user_banned' => 'Puede banear/bloquear.',
                    'user_permissions' => ' Puede otorgar permisos.',
                    'user_show' => 'Puede ver.',
                ]
            ],
            'company' => [
                'icon' => '<i class="fal fa-building"></i>',
                'title' => 'Modulo Área Corporativa',
                'keys' => [
                    'company' => 'Puede ver el listado.',
                    'company_edit' => 'Puede editar.',
                    'company_add' => 'Puede agregar.',
                    'company_delete' => 'Puede elimiar.',
                ]
            ],
            'carousels' => [
                'icon' => '<i class="far fa-object-group"></i>',
                'title' => 'Modulo Imagen de inicio',
                'keys' => [
                    'carousels' => 'Puede ver el listado.',
                    'carousel_edit' => 'Puede editar.',
                    'carousel_add' => 'Puede agregar.',
                    'carousel_delete' => 'Puede elimiar.',
                ]
            ],
            'categories' => [
                'icon' => '<i class="far fa-warehouse-alt"></i>',
                'title' => 'Modulo de Categorias',
                'keys' => [
                    'categories' => 'Puede ver el listado.',
                    'category_edit' => 'Puede editar.',
                    'category_add' => 'Puede agregar.',
                    'category_delete' => 'Puede elimiar.',
                ]
            ],
            'technics' => [
                'icon' => '<i class="fal fa-pencil-paintbrush"></i>',
                'title' => 'Modulo de Tecnicas',
                'keys' => [
                    'technics' => 'Puede ver el listado.',
                    'technic_edit' => 'Puede editar.',
                    'technic_add' => 'Puede agregar.',
                    'technic_delete' => 'Puede elimiar.',
                ]
            ],
            'artists' => [
                'icon' => '<i class="fal fa-head-side-brain"></i>',
                'title' => 'Modulo de Artistas',
                'keys' => [
                    'artists' => 'Puede ver el listado.',
                    'artist_edit' => 'Puede editar.',
                    'artist_add' => 'Puede agregar.',
                    'artist_delete' => 'Puede elimiar.',
                ]
            ],
            'articles' => [
                'icon' => '<i class="fal fa-paint-brush-alt"></i>',
                'title' => 'Modulo de Articulos',
                'keys' => [
                    'articles' => 'Puede ver el listado.',
                    'article_edit' => 'Puede editar.',
                    'article_add' => 'Puede agregar.',
                    'article_delete' => 'Puede elimiar.',
                ]
            ],
            'categories' => [
                'icon' => '<i class="fal fa-send-backward"></i>',
                'title' => 'Modulo de Categorias',
                'keys' => [
                    'categories' => 'Puede ver el listado.',
                    'category_edit' => 'Puede editar.',
                    'category_add' => 'Puede agregar.',
                    'category_delete' => 'Puede elimiar.',
                ]
            ],
            // 'tags' => [
            //     'icon' => '<i class="fal fa-tags"></i>',
            //     'title' => 'Modulo de Etiquetas',
            //     'keys' => [
            //         'tags' => 'Puede ver el listado.',
            //         'tag_edit' => 'Puede editar.',
            //         'tag_add' => 'Puede agregar.',
            //         'tag_delete' => 'Puede elimiar.',
            //     ]
            // ],
            'news' => [
                'icon' => '<i class="fal fa-newspaper"></i>',
                'title' => 'Modulo de Noticias',
                'keys' => [
                    'news' => 'Puede ver el listado.',
                    'new_edit' => 'Puede editar.',
                    'new_add' => 'Puede agregar.',
                    'new_delete' => 'Puede elimiar.',
                ]
            ],
            'projects' => [
                'icon' => '<i class="fal fa-construction"></i>',
                'title' => 'Modulo de Proyectos',
                'keys' => [
                    'projects' => 'Puede ver el listado.',
                    'project_edit' => 'Puede editar.',
                    'project_add' => 'Puede agregar.',
                    'project_delete' => 'Puede elimiar.',
                ]
            ],
            'massive' => [
                'icon' => '<i class="far fa-money-check"></i>',
                'title' => 'Modulo de Modificación masiva',
                'keys' => [
                    'massives' => 'Puede ver el listado.',
                    'massive_edit' => 'Puede editar.',
                    'massive_add' => 'Puede agregar.',
                    'massive_delete' => 'Puede elimiar.',
                ]
            ],

        ];
        return $p;
    }

    function getExchangeRate()
    {
        $url = "https://openexchangerates.org/api/latest.json?app_id=1aa521bde58f402080453d19dda32dfa";

        $response = file_get_contents($url);
        if (!$response) {
            return null;
        }

        $data = json_decode($response, true);

        if ($data) {
            return $data['rates']['MXN'];
        } else {
            return null;
        }
    }

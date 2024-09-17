<?php

use Illuminate\Database\Seeder;
use App\CorporateArea;

class CorporateAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CorporateArea::create([
            'icon' => '<i class="fal fa-newspaper"></i>',
            'name' => 'Logo y Descripción Corta',
            'slug' => 'logo-y-descripcion-corta',
            'orden_dash' => '1',
            'file_path' => '/Company',
            'file' => '892-nodum-logo-500x500px.png',
        ]);
        CorporateArea::create([
            'icon' => '<i class="far fa-cookie"></i>',
            'name' => 'Política de Cache',
            'slug' => 'politica-de-cache',
            'orden_dash' => '8',
        ]);
        CorporateArea::create([
            'icon' => '<i class="fal fa-money-check-edit"></i>',
            'name' => 'Aviso de Privacidad',
            'slug' => 'aviso-de-privacidad',
            'orden_dash' => '6',
        ]);
        CorporateArea::create([
            'icon' => '<i class="far fa-users-class"></i>',
            'name' => 'Condiciones de uso',
            'slug' => 'condiciones-de-uso',
            'orden_dash' => '9',

        ]);
        CorporateArea::create([
            'icon' => '<i class="fal fa-poll-h"></i>',
            'name' => 'Políticas Generales de Servicio',
            'slug' => 'politicas-generales-de-servicio',
            'orden_dash' => '7',
        ]);
        CorporateArea::create([
            'icon' => '<i class="fal fa-comment-alt-exclamation"></i>',
            'name' => 'Misión',
            'slug' => 'mision',
            'orden_dash' => '2',
        ]);
        CorporateArea::create([
            'icon' => '<i class="far fa-glasses-alt"></i>',
            'name' => 'Visión',
            'slug' => 'vision',
            'orden_dash' => '3',

        ]);
        CorporateArea::create([
            'icon' => '<i class="fal fa-users-crown"></i>',
            'name' => 'Nosotros',
            'slug' => 'nosotros',
            'orden_dash' => '4',
            'status' => 'published',
            'description' => '&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;NODUM, con cinco a&amp;ntilde;os de trayectoria, se crea como un proyecto pionero en promoci&amp;oacute;n y gesti&amp;oacute;n cultural. Con una perspectiva &amp;uacute;nica, nos dedicamos a vincular el arte con el p&amp;uacute;blico, trascendiendo las barreras tradicionales. A trav&amp;eacute;s de diversos medios como subastas, exposiciones y ventas directas a la cartera de clientes, NODUM crea un espacio din&amp;aacute;mico para la apreciaci&amp;oacute;n art&amp;iacute;stica. Lo que realmente distingue a NODUM es su compromiso directo con un selecto portafolio de artistas, proporcion&amp;aacute;ndoles apoyo integral para posicionar y dar a conocer sus obras. NODUM no solo promueve el arte, sino que construye puentes entre la creatividad y aquellos que buscan experiencias art&amp;iacute;sticas significativas.&lt;/span&gt;&lt;/p&gt;',
        ]);
        CorporateArea::create([
            'icon' => '<i class="fal fa-id-card"></i>',
            'name' => 'Contacto',
            'slug' => 'contacto',
            'orden_dash' => '5',
            'direction' => '&lt;p&gt;Av. Tamaulipas 56, Hip&amp;oacute;dromo, Cuauht&amp;eacute;moc, 06100 Ciudad de M&amp;eacute;xico, CDMX,M&amp;eacute;xico&lt;/p&gt;',
            'phone' => '5555555555',
            'email' => 'nodum@nodum.art',
        ]);
    }
}


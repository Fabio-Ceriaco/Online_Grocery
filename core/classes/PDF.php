<?php

namespace core\classes;

use Mpdf\Mpdf;


class PDF
{
    private $pdf;
    private $html;

    //posição
    private $x;  //left
    private $y;  //top
    private $align; //text-alignment

    //dimenssão 
    private $width;
    private $height;

    //cor
    private $color;
    private $background_color;

    // letra
    private $font_family;
    private $font_size;
    private $font_weight;

    private $show_areas; // mostar ou esconde um contorno em volta das áreas de texto


    //================================================================================================================
    //  CONSTRUTOR DA CLASS
    //================================================================================================================
    public function __construct($formato = 'A4', $orientacao = 'P', $modo = 'utf-8')
    {
        // cria a instância da classe Mpdf

        $this->pdf = new Mpdf([
            'tempDir' => '/tmp',
            'format' => $formato,
            'orientation' => $orientacao,
            'mode' => $modo,
        ]);

        // iniciar o html
        $this->resetHtml();
        $this->show_areas = false;
    }

    //================================================================================================================
    //  DEFINIR TEMPLATE PDF
    //================================================================================================================

    public function set_pdf_template($template)
    {

        // carregar o template PDF

        $this->pdf->SetDocTemplate($template);
    }

    //================================================================================================================
    //  CONFIGURAÇÔES PARA DEFINIÇÂO DA POSIÇÂO E DIMENSÂO DO TEXTO
    //================================================================================================================

    public function set_x($x)
    {

        // definir posição horizontal
        $this->x = $x;
    }

    //================================================================================================================
    public function set_y($y)
    {

        // definir posição vertical

        $this->y = $y;
    }

    //================================================================================================================
    public function set_width($width)
    {

        // definir largura

        $this->width = $width;
    }

    //================================================================================================================
    public function set_height($height)
    {

        // definir largura

        $this->height = $height;
    }
    //================================================================================================================
    public function set_position($x, $y)
    {

        // definir posição

        $this->x = $x;

        $this->y = $y;
    }

    //================================================================================================================

    public function set_dimensions($width, $height)
    {

        // definir dimensões

        $this->width = $width;
        $this->height = $height;
    }

    //================================================================================================================

    public function set_position_dimension($x, $y, $width, $height)
    {

        // definir posições e dimensões do espaço do texto

        $this->set_position($x, $y);
        $this->set_dimensions($width, $height);
    }

    //================================================================================================================
    //  CONFIGURAÇÔES PARA ALINHAMENTO DO TEXTO
    //================================================================================================================
    public function set_align($align)
    {

        // definir alinhamento do texto

        $this->align = $align;
    }

    //================================================================================================================
    // CONFIGURAÇÔES PARA DEFINIÇÂO DA COR DE TEXTO E COR DE FUNDO
    //================================================================================================================
    public function set_color($color)
    {

        // definir cor de texto

        $this->color = $color;
    }

    //================================================================================================================
    public function set_background_color($color)
    {

        // definir cor de fundo

        $this->background_color = $color;
    }

    //================================================================================================================
    // CONFIGURAÇÔES PARA DEFINIÇÂO DA LETRA (FAMILIA, TAMANHO E TIPO)
    //================================================================================================================
    public function set_font_family($font_family)
    {

        // definir font de letra
        $font_family = ucwords($font_family);


        $fonts = [
            'Courier New',
            'Franklin Gothic',
            'Helvetica',
            'Lucinda sans',
            'Times New Roman',
            'Verdana'
        ];




        // verificar se tipo de letar pertence ao array de fonts
        if (!in_array($font_family, $fonts)) {

            $this->font_family = 'Arial';
        } else {

            $this->font_family = $font_family;
        }
    }

    //================================================================================================================

    public function set_font_size($font_size)
    {

        // definir tamanho de letra

        $this->font_size = $font_size;
    }

    //================================================================================================================

    public function set_font_weight($font_weight)
    {

        // definir tipo de letra

        $this->font_weight = $font_weight;
    }


    //================================================================================================================
    // MÉTODOS PARA MANIPULAÇÂO DO DOCUMENTO
    //================================================================================================================
    public function resetHtml()
    {

        // coloca o html em branco
        $this->html = '';
    }


    //================================================================================================================

    public function new_page()
    {

        // acrescentar uma nova página ao pdf

        $this->html .= '<pagebreak>';
    }

    //================================================================================================================

    public function write($text)
    {

        // escreve texto no documento
        $this->html .= '<div style="';

        // posicionamento e dimensão
        $this->html .= 'position: absolute;';
        $this->html .= 'left: ' . $this->x . 'px;';
        $this->html .= 'top: ' . $this->y . 'px;';
        $this->html .= 'width: ' . $this->width . 'px;';
        $this->html .= 'height: ' . $this->height . 'px;';

        // alinhamento
        $this->html .= 'text-align: ' . $this->align . ';';

        // cores
        $this->html .= 'color: ' . $this->color . ';';
        $this->html .= 'background-color: ' . $this->background_color . ';';

        // letra
        $this->html .= 'font-family: ' . $this->font_family . ';';
        $this->html .= 'font-size: ' . $this->font_size . ';';
        $this->html .= 'font-weight: ' . $this->font_weight . ';';


        // mostrar contorno da area

        if ($this->show_areas) {

            $this->html .= 'box-shadow: inset 0px 0px 0px 1px red;';
        }

        $this->html .= '">' . $text . '</div>';
    }



    //================================================================================================================
    public function show_pdf()
    {

        // output para o browser ou ficheiro pdf
        $this->pdf->WriteHTML($this->html);
        $this->pdf->Output();
    }

    //================================================================================================================

    public function save_pdf($pdf_name)
    {

        // guardar o ficheiro pdf com o nome pretendido
        $this->pdf->WriteHTML($this->html);
        $this->pdf->Output(PDF_PATH . $pdf_name);
    }

    //================================================================================================================
    // MÉTODOS PARA DEFINIÇÂO DE PREMISSÔES DO DOCUMENTO
    //================================================================================================================

    public function set_premissions($premissions = [], $password = '')
    {

        // definir premissões para o documento a ser criado

        $this->pdf->SetProtection($premissions, $password);
    }
}

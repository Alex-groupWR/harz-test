<?php

use WebPConvert\WebPConvert;

/**
 * Класс конвертации изображения в формат WebP
 * Class IblockImageConvert
 */
class IblockImageConvert
{
    const TYPE_ELEMENT = 'element';
    const TYPE_SECTION = 'section';
    public $sourceImage = 'PREVIEW_PICTURE';
    public $destinationProperty = 'PREVIEW_PICTURE';
    public $tmpDir = '/upload/tmp';
    public $converterUrl = 'https://cargopost.com/image_convert/?image_url=';
    public $siteUrl = 'http://store.harzlabs.com';

    public $type = self::TYPE_ELEMENT;

    /**
     * Id инфоблока в котором производится конвертация
     * @var integer
     */
    public $iBlockId;

    /**
     * Id элемента инфоблока в котором производится конвертация
     * @var integer
     */
    public $iBlockElementId;

    /**
     * Путь до изображения
     * @var string
     */
    public $src;

    public $srcConverted;


    public function __construct(array $configure)
    {
        $this->iBlockId = $configure['iBlockId'];
        $this->iBlockElementId = $configure['iBlockElementId'];

        if($configure['src']){
            $this->src = $configure['src'];
        } else {
            $this->src = $this->getImageSrcFromIblock();
        }

        if($configure['type']){
            $this->type = $configure['type'];
        }

        if($configure['tmpDir']){
            $this->tmpDir = $configure['tmpDir'];
        }

        //$this->src = $_SERVER['DOCUMENT_ROOT'].$this->src;
        //$this->src = $this->siteUrl.$this->src;

        //$this->tmpDir = $_SERVER['DOCUMENT_ROOT'].$this->tmpDir;

        $this->srcConverted = $this->getConvertedSrc();
    }

    /**
     * Запускает процесс конвертации и сохранения изображения
     */
    public function run()
    {
        // Конвертируем изображение и сохраняем в инфоблок
        if($this->convertToWebP() && $this->saveToIblock()){
            return $this->getFromIblock();
        }

        return null;
    }

    /**
     * Возвращает путь до временного изображения
     * @return string
     */
    public function getConvertedSrc()
    {
        $file = pathinfo($this->src);

        return $this->tmpDir.'/'.$file['basename'].'.webp';
    }

    /**
     * Возвращает путь для изображения из элемеента инфоблока
     * @return string
     */
    protected function getImageSrcFromIblock()
    {
        return '';
    }

    /**
     * Конвертирует изображение в формат WebP
     * @return string
     * @throws \WebPConvert\Convert\Exceptions\ConversionFailedException
     */
    public function convertToWebP()
    {
        $this->removeTmpImage();

        $temp_image = file_get_contents($this->converterUrl.$this->src);

        file_put_contents($this->srcConverted, $temp_image);

        if(is_file($this->srcConverted)){
            return true;
        }

        return false;
    }

    /**
     * Удаляет временное изображение
     */
    protected function removeTmpImage()
    {
        if(is_file($this->srcConverted)){
            unlink($this->srcConverted);
        }
    }


    /**
     * Сохраняет изображение в свойство инфоблока
     */
    protected function saveToIblock()
    {
        $arSrcConvert = CFile::MakeFileArray($this->srcConverted);

        if($this->type == self::TYPE_ELEMENT) {
            return CIBlockElement::SetPropertyValueCode(
                $this->iBlockElementId,
                $this->destinationProperty,
                $arSrcConvert);
        } else {

            global $USER_FIELD_MANAGER;

            return $USER_FIELD_MANAGER->Update( 'IBLOCK_'.$this->iBlockId.'_SECTION', $this->iBlockElementId, array(
                'UF_PREVIEW_PICTURE'  => $arSrcConvert
            ) );
        }
    }

    /**
     * Возвращает значение свойства из инфоблока
     * @return array|null
     */
    protected function getFromIblock()
    {
        if($this->type == self::TYPE_ELEMENT) {

            $res = CIBlockElement::GetProperty(
                $this->iBlockId,
                $this->iBlockElementId,
                "sort",
                "asc",
                array("CODE" => $this->destinationProperty)
            );

            if ($val = $res->GetNext()) {
                return $val;
            }

        } else {

            global $USER_FIELD_MANAGER;

            return $USER_FIELD_MANAGER->GetUserFieldValue(
                'IBLOCK_'.$this->iBlockId.'_SECTION',
                'UF_PREVIEW_PICTURE',
                $this->iBlockElementId
            );

        }

        return null;
    }



}
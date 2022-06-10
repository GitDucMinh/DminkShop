<?php

namespace App\Http\Controllers\api\v1\Common;

use App\Utils\ErrorMessage;

class DataResponse
{
    public $Code;
    public $Data;
    public $DataErrors;
    public $Message;
    public $MessageNo;

    public function __construct()
    {
        $this->Code         = ResponseCode::OK;
        $this->Data         = [];
        $this->Message      = '';
        $this->MessageNo    = '';
        $this->DataErrors   = [];
    }

    /**
     * Set data to return a exception
     * Created: 2022/06/09
     * @author GitDucMinh<21ducminh@gmail.com>
     * @param \Exception $e Exception had throewed
     */
    public function setException($e)
    {
        $this->Code         = ResponseCode::SERVICE_ERROR;
        $this->Data         = [];
        $this->Message      = $e->getMessage();
        $this->MessageNo    = 'E500';
        $this->DataErrors   = [
            'Instance'   => get_class($e),
            'Line'       => $e->getLine(),
            'File'       => basename($e->getFile()),
            'Code'       => $e->getCode()
        ];
    }

    /**
     * Get data to return to client follow common format
     * Created: 2022/06/09
     * @author GitDucMinh<21ducminh@gmail.com>
     */
    public function GetData()
    {
        $fieldName = '';
        $message = '';
        if ($this->DataErrors && !isset($this->DataErrors["Line"])) {
            foreach ($this->DataErrors as $key => $value) {
                $fieldName = $key;
                $this->MessageNo = $value[0];
                break;
            }
        }
        if ($this->Code != ResponseCode::OK) {
            if (array_key_exists($this->MessageNo, ErrorMessage::MSG)) {
                $message = ErrorMessage::MSG[$this->MessageNo];
            } else {
                $message = 'Lỗi hệ thống. Vui lòng thử lại sau';
            }
        }

        $this->MessageNo = $this->MessageNo;
        $this->Message = str_replace("{0}", $fieldName, $message);

        return [
            'Code'          => $this->Code,
            'Data'          => $this->Data,
            'MessageNo'     => $this->MessageNo,
            'Message'       => $this->Message,
            'DataErrors'    => $this->DataErrors
        ];
    }
}

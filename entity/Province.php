<?php

class Province implements JsonSerializable {

    private $provinceCode;
    private $provinceName;

    public function __construct($provinceCode, $provinceName) {
        $this->provinceCode = $provinceCode;
        $this->provinceName = $provinceName;
    }

    function getProvinceCode() {
        return $this->provinceCode;
    }

    function getProvinceName() {
        return $this->provinceName;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

}

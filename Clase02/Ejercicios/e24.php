<?php

class Operario
{
    private string $_apellido;
    private int $_legajo;
    private string $_nombre;
    private float $_salario;

    public function __construct(int $legajo, string $apellido, string $nombre) {
        $this->_apellido = $apellido;
        $this->_legajo = $legajo;
        $this->_nombre = $nombre;
        $this->_salario = 0;
    }

    static function Equals(Operario $op1, Operario $op2) : bool {
        if ($op1->_legajo == $op2->_legajo && $op1->_nombre == $op2->_nombre && $op1->_apellido == $op2->_apellido) {
            return true;
        }
        return false;
    }

    public function GetNombreApellido() : string {
        return $this->_nombre . "," . $this->_apellido;
    }

    public function GetSalario() : float {
        return $this->_salario;
    }

    public function Mostrar() : string {
        return $this->GetNombreApellido() . "," . $this->_legajo . "," . $this->_salario;
    }

    static function MostrarClase(Operario $op) : string {
        return $op->Mostrar();
    }

    public function SetAumentarSalrio(float $aumento) : void {
        $this->_salario += $this->_salario * $aumento;
    }

}

class Fabrica
{
    private int $_cantMaxOperarios;
    private $_operarios;
    private string $_razonSocial;

    public function __construct(string $rs) {
        $this->_razonSocial = $rs;
        $this->_operarios = array();
        $this->_cantMaxOperarios = 30;
    }

    public function Add(Operario $op) : bool{
        if (count($this->_operarios) < $this->_cantMaxOperarios && !Fabrica::Equals($this, $op)) {
            $this->_operarios[] = $op;
        }
        return false;
    }

    static function Equals(Fabrica $fb, Operario $op) : bool {
        foreach ($fb->_operarios as $operario) {
            if (Operario::Equals($operario, $op)) {
                return true;
            }
        }
        return false;
    }

    public function Mostrar() : string {
        return $this->MostrarOperarios();
    }

    static function MostrarCosto(Fabrica $fb) : void {
        echo $fb->RetornarCostos();
    }

    private function MostrarOperarios() : string {
        $retorno = "";
        foreach ($this->_operarios as $operario) {
            $retorno .= $operario->Mostrar();
        }
        return $retorno;
    }

    public function Remove(Operario $op) : bool {
        foreach ($this->_operarios as $key => $operario) {
            if (Fabrica::Equals($this, $op)) {
                unset($this->_operarios[$key]);
                return true;
            }
        }
        return false;
    }

    private function RetornarCostos() : float {
        $sumaSalario = 0;
        foreach ($this->_operarios as $operario) {
            $sumaSalario += $operario->GetSalario();
        }
        return $sumaSalario;
    }
}

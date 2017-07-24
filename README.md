# Comprobante Fiscal Digital por Internet (CFDI)

[![Latest Stable Version](https://poser.pugx.org/orlandocharles/cfdi/version)](https://packagist.org/packages/orlandocharles/cfdi) [![Latest Unstable Version](https://poser.pugx.org/orlandocharles/cfdi/v/unstable)](//packagist.org/packages/orlandocharles/cfdi) [![Total Downloads](https://poser.pugx.org/orlandocharles/cfdi/downloads)](https://packagist.org/packages/orlandocharles/cfdi) [![License](https://poser.pugx.org/orlandocharles/cfdi/license)](https://packagist.org/packages/orlandocharles/cfdi) [![Donate](https://img.shields.io/badge/Donate-PayPal-3b7bbf.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=H2KAFWPGPMKHJ)

- [Instalación](#instalación)
- [Uso](#uso)
- [Licencia](#licencia)
- [Donación](#donación)

## Instalación

Para instalar el paquete mediante [Composer](https://getcomposer.org/).

```
$ composer require orlandocharles/cfdi
```

## Uso

- [CFDI](#cfdi)
- [CFDI Relacionado](#cfdi-relacionado)
- [Emisor](#emisor)
- [Receptor](#receptor)
- [Concepto](#concepto)
- [Impuestos](#concepto) (dev)
- [Información Aduanera](#información-aduanera)
- [Cuenta Predial](#cuenta-predial)
- [Parte](#parte)

### CFDI

```php
<?php
use Charles\CFDI\CFDI;

$cer = file_get_contents('.../csd/AAA010101AAA.cer.pem');
$key = file_get_contents('.../csd/AAA010101AAA.key.pem');

$cfdi = new CFDI([
    'Folio' => 'A0101',
    'Fecha' => '2017-06-17T03:00:00',
    'Serie' => 'A',
    'FormaPago' => '01',
    'Moneda' => 'MXN',
    'TipoDeComprobante' => 'I',
    'FormaPago' => '01',
    'TipoCambio' => '1.0',
    'Descuento' => '0.00',
    'LugarExpedicion' => '64000',
], $cer, $key);
```

### CFDI Relacionado

En este nodo se debe expresar la información de los comprobantes fiscales relacionados con el que se ésta generando, se deben expresar tantos numeros de nodos de CfdiRelacionado, como comprobantes se requieran relacionar.

```php
<?php
use Charles\CFDI\CFDI;
use Charles\CFDI\Relacionado;

$cfdi = new CFDI([...]);

$cfdi->add(new Relacionado([
    'UUID' => 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX',
]));
```

### Emisor

En este nodo se debe expresar la información del contribuyente que emite el comprobante fiscal.

```php
<?php
use Charles\CFDI\CFDI;
use Charles\CFDI\Emisor;

$cfdi = new CFDI([...]);

$cfdi->add(new Emisor([
    'Rfc' => 'XAXX010101000',
    'Nombre' => 'Orlando Charles',
]));
```

### Receptor

En este nodo se debe expresar la información del contribuyente receptor del comprobante.

```php
<?php
use Charles\CFDI\CFDI;
use Charles\CFDI\Receptor;

$cfdi = new CFDI([...]);

$cfdi->add(new Receptor([
    'Rfc' => 'XAXX010101000',
    'Nombre' => 'Orlando Charles',
    'ResidenciaFiscal' => 'MEX'
]));
```

### Concepto

En este nodo se debe expresar la información detallada de un bien o servicio descrito en el comprobante.

```php
<?php
use Charles\CFDI\CFDI;
use Charles\CFDI\Concepto;

$cfdi = new CFDI([...]);

$cfdi->add(new Concepto([
    'ClaveProdServ' => '10317331',
    'ClaveUnidad' => 'H87',
    'Cantidad' => '24',
    'Descripcion' => 'Arreglo de 24 tulipanes rosadas recién cortados',
    'ValorUnitario' => '56.00',
    'Importe' => '1344.00',
]));

$cfdi->add(new Concepto([
    'ClaveProdServ' => '10317352',
    'ClaveUnidad' => 'H87',
    'Cantidad' => '12',
    'Descripcion' => 'Arreglo de 12 tulipanes rojos recién cortados',
    'ValorUnitario' => '66.00',
    'Importe' => '792.00',
]));
```

### Impuestos (dev)

#### Retención

En este nodo se debe expresar la información detallada de una retención de un impuesto específico.

```php
<?php
use Charles\CFDI\CFDI;
use Charles\CFDI\Impuesto\Retencion;

$cfdi->add(new Retencion([
    "Impuesto" => "002",
    "Importe" => "35000",
]));
```

#### Traslado

En este nodo se debe expresar la información detallada de un traslado de impuesto específico.

```php
<?php
use Charles\CFDI\CFDI;
use Charles\CFDI\Impuesto\Traslado;

$cfdi->add(new Traslado([
    "Impuesto" => "001",
    "TipoFactor" => "Tasa",
    "TasaOCuota" => "0.160000",
    "Importe" => "23000",
]));
```

### Información Aduanera

En este nodo se debe expresar la información aduanera correspondiente a cada concepto cuando se trate de ventas de primera mano de mercancías importadas

```php
<?php
use Charles\CFDI\CFDI;
use Charles\CFDI\Concepto;
use Charles\CFDI\InformacionAduanera;

$cfdi = new CFDI([...]);
$concepto = new Concepto([...]);

$concepto->add(new InformacionAduanera([
    "NumeroPedimento" => "00 00 0000 0000000",
]));
```

### Cuenta Predial

En este nodo se puede expresar el número de cuenta predial con el que fue registrado el inmueble en el sistema catastral de la entidad federativa de que trate, o bien para incorporar los datos de identificación del certificado de participación inmobiliaria no amortizable.

```php
<?php
use Charles\CFDI\CFDI;
use Charles\CFDI\Concepto;
use Charles\CFDI\CuentaPredial;

$cfdi = new CFDI([...]);
$concepto = new Concepto([...]);

$concepto->add(new CuentaPredial([
    "Numero" => "00000",
]));
```

### Parte

En este nodo se pueden expresar las partes o componentes que integran la totalidad del concepto expresado en el comprobante fiscal digital por Internet.

```php
<?php
use Charles\CFDI\CFDI;
use Charles\CFDI\Concepto;
use Charles\CFDI\Parte;
use Charles\CFDI\InformacionAduanera;

$cfdi = new CFDI([...]);
$concepto = new Concepto([...]);
$InformacionAduanera = new InformacionAduanera([...]);

$parte = new Parte([
    "ClaveProdServ" => "01010101",
    "NoIdentificacion" => "000000",
    "Cantidad" => "1.0",
    "Descripcion" => "Lorem ipsum dolor sit amet",
    "ValorUnitario" => "1.00",
    "Importe" => "1.00",
]);

$InformacionAduanera->add($parte);
$cfdi->add($InformacionAduanera);
```

## Licencia

Este paquete no pertenece a ninguna comañia ni entidad gubernamental y esta bajo la Licencia MIT, si quieres saber más al respecto puedes ver el archivo de [Licencia](LICENSE) que se encuentra en este mismo repositorio.

## Donación

Este proyecto ayuda a que otros desarrolladores ahorren horas de trabajo.

[![paypal](https://www.paypalobjects.com/es_XC/MX/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=H2KAFWPGPMKHJ)

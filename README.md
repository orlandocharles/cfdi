# Comprobante Fiscal Digital por Internet (CFDI)

[![License](https://poser.pugx.org/orlandocharles/cfdi/license)](https://packagist.org/packages/orlandocharles/cfdi) [![Donate](https://img.shields.io/badge/Donate-PayPal-3b7bbf.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=H2KAFWPGPMKHJ)

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
- [Emisor](#emisor)
- [Receptor](#receptor)
- [Concepto](#concepto)

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

## Licencia

Este paquete no pertenece a ninguna comañia ni entidad gubernamental y esta bajo la Licencia MIT, si quieres saber más al respecto puedes ver el archivo de [Licencia](LICENSE) que se encuentra en este mismo repositorio.

## Donación

Este proyecto ayuda a que otros desarrolladores ahorren horas de trabajo.

[![paypal](https://www.paypalobjects.com/es_XC/MX/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=H2KAFWPGPMKHJ)

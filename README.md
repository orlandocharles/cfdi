# Comprobante Fiscal Digital por Internet (CFDI v3.3)

[![Source Code][badge-source]][source]
[![Latest Version][badge-release]][release]
[![Software License][badge-license]][license]
[![Build Status][badge-build]][build]
[![Scrutinizer][badge-quality]][quality]
[![Coverage Status][badge-coverage]][coverage]
[![Total Downloads][badge-downloads]][downloads]
[![SensioLabsInsight][badge-sensiolabs]][sensiolabs]

## Instalación

> Nota: el proyecto se encuentra en desarrollo.

Para instalar el paquete mediante [Composer](https://getcomposer.org/).

```shell
composer require eclipxe/cfdi
```

## Uso

- [CFDI](#cfdi)
- [CFDI Relacionado](#cfdi-relacionado)
- [Emisor](#emisor)
- [Receptor](#receptor)
- [Concepto](#concepto)
- [Impuestos](#impuestos)

  - [Traslado](#traslado)

    - [Traslado en comprobante](#traslado-en-comprobante)
    - [Traslado en concepto](#traslado-en-concepto)

  - [Retención](#retención)

    - [Retención en comprobante](#retención-en-comprobante)
    - [Retención en concepto](#retención-en-concepto)

- [Información Aduanera](#información-aduanera)

- [Cuenta Predial](#cuenta-predial)
- [Parte](#parte)
- [Complemento Pagos](#pago)
        - [Documento Relacionado](#pago-documento-relacionado)
        - [Impuesto retenido](#retención-en-pago)
        - [Impuesto trasladado](#traslado-en-pago)
        
        
### CFDI

```php
<?php
use PhpCfdi\CFDI\CFDI;

$cfdi = new CFDI([
    'Serie' => 'A',
    'Folio' => 'A0101',
    'Fecha' => '2017-06-17T03:00:00',
    'FormaPago' => '01',
    'CondicionesDePago' => '',
    'Subtotal' => '',
    'Descuento' => '0.00',
    'Moneda' => 'MXN',
    'TipoCambio' => '1.0',
    'Total' => '',
    'TipoDeComprobante' => 'I',
    'MetodoPago' => 'PUE',
    'LugarExpedicion' => '64000',
]);

$cfdi->addCertificado(new \CfdiUtils\Certificado('.../csd/AAA010101AAA.cer'));
$cfdi->setPrivateKey(file_get_contents('.../csd/AAA010101AAA.key.pem'));
```

### CFDI Relacionado

En este nodo se debe expresar la información de los comprobantes fiscales relacionados con el que se ésta generando, se deben expresar tantos numeros de nodos de CfdiRelacionado, como comprobantes se requieran relacionar.

```php
<?php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Relacionado;

$cfdi = new CFDI([]);

$cfdi->add(new Relacionado(
    [ // atributos del nodo cfdi:Relacionado
        'UUID' => 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX'
    ],
    [ // atributos del nodo padre cfdi:Relacionados
        'TipoRelacion' => '01'
    ]
));
```

```xml
<cfdi:CfdiRelacionados TipoRelacion="01">
  <cfdi:CfdiRelacionado UUID="XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX"/>
</cfdi:CfdiRelacionados>
```

### Emisor

En este nodo se debe expresar la información del contribuyente que emite el comprobante fiscal.

```php
<?php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Emisor;

$cfdi = new CFDI([]);

$cfdi->add(new Emisor([
    'Rfc' => 'XAXX010101000',
    'Nombre' => 'Florería SA de CV',
    'RegimenFiscal' => '601',
]));
```

```xml
<cfdi:Emisor Rfc="XAXX010101000" Nombre="Florería SA de CV" RegimenFiscal="601"/>
```

### Receptor

En este nodo se debe expresar la información del contribuyente receptor del comprobante.

```php
<?php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Receptor;

$cfdi = new CFDI([]);

$cfdi->add(new Receptor([
    'Rfc' => 'XEXX010101000',
    'Nombre' => 'Orlando Charles',
    'ResidenciaFiscal' => 'USA',
    'NumRegIdTrib' => '121585958',
    'UsoCFDI' => 'G01',
]));
```

```xml
<cfdi:Receptor Rfc="XEXX010101000" Nombre="Orlando Charles" ResidenciaFiscal="USA" NumRegIdTrib="121585958" UsoCFDI="G01"/>
```

### Concepto

En este nodo se debe expresar la información detallada de un bien o servicio descrito en el comprobante.

```php
<?php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Concepto;

$cfdi = new CFDI([]);

$cfdi->add(new Concepto([
    'ClaveProdServ' => '10317331',
    'NoIdentificacion' => 'UT421511',
    'Cantidad' => '24',
    'ClaveUnidad' => 'H87',
    'Unidad' => 'Pieza',
    'Descripcion' => 'Arreglo de 24 tulipanes rosadas recién cortados',
    'ValorUnitario' => '56.00',
    'Importe' => '1344.00',
    'Descuento' => '10.00',
]));

$cfdi->add(new Concepto([
    'ClaveProdServ' => '10317352',
    'NoIdentificacion' => 'UT421510',
    'Cantidad' => '12',
    'ClaveUnidad' => 'H87',
    'Unidad' => 'Pieza',
    'Descripcion' => 'Arreglo de 12 tulipanes rojos recién cortados',
    'ValorUnitario' => '66.00',
    'Importe' => '792.00',
    'Descuento' => '5.00',
]));
```

```xml
<cfdi:Conceptos>
  <cfdi:Concepto ClaveProdServ="10317331" NoIdentificacion="UT421511" Cantidad="24" ClaveUnidad="H87" Unidad="Pieza" Descripcion="Arreglo de 24 tulipanes rosadas recién cortados" ValorUnitario="56.00" Importe="1344.00" Descuento="10.00"/>
  <cfdi:Concepto ClaveProdServ="10317352" NoIdentificacion="UT421510" Cantidad="12" ClaveUnidad="H87" Unidad="Pieza" Descripcion="Arreglo de 12 tulipanes rojos recién cortados" ValorUnitario="66.00" Importe="792.00" Descuento="5.00"/>
</cfdi:Conceptos>
```

### Impuestos

#### Retención

##### Retención en comprobante

En este nodo se debe expresar la información detallada de una retención de un impuesto específico.

```php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Impuesto\Retencion;

$cfdi->add(new Retencion([
    'Impuesto' => '002',
    'Importe' => '35000',
]));
```

##### Retención en concepto

```php
<?php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Concepto;
use PhpCfdi\CFDI\Node\Impuesto\Retencion;

$cfdi = new CFDI([]);

$concepto = new Concepto([
    'ClaveProdServ' => '10317331',
    'NoIdentificacion' => 'UT421511',
    'Cantidad' => '24',
    'ClaveUnidad' => 'H87',
    'Unidad' => 'Pieza',
    'Descripcion' => 'Arreglo de 24 tulipanes rosadas recién cortados',
    'ValorUnitario' => '56.00',
    'Importe' => '1344.00',
    'Descuento' => '10.00',
]);

$concepto->add(new Retencion([

]));

$cfdi->add($concepto);
```

#### Traslado

##### Traslado en comprobante

En este nodo se debe expresar la información detallada de un traslado de impuesto específico.

```php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Impuesto\Traslado;

$cfdi->add(new Traslado([
    'Impuesto' => '001',
    'TipoFactor' => 'Tasa',
    'TasaOCuota' => '0.160000',
    'Importe' => '23000',
]));
```

##### Traslado en concepto

```php
<?php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Concepto;
use PhpCfdi\CFDI\Node\Impuesto\Traslado;

$cfdi = new CFDI([]);

$concepto = new Concepto([
    'ClaveProdServ' => '10317331',
    'NoIdentificacion' => 'UT421511',
    'Cantidad' => '24',
    'ClaveUnidad' => 'H87',
    'Unidad' => 'Pieza',
    'Descripcion' => 'Arreglo de 24 tulipanes rosadas recién cortados',
    'ValorUnitario' => '56.00',
    'Importe' => '1344.00',
    'Descuento' => '10.00',
]);

$concepto->add(new Traslado([

]));

$cfdi->add($concepto);
```

### Información Aduanera

En este nodo se debe expresar la información aduanera correspondiente a cada concepto cuando se trate de ventas de primera mano de mercancías importadas

```php
<?php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Concepto;
use PhpCfdi\CFDI\Node\InformacionAduanera;

$cfdi = new CFDI([]);

$concepto = new Concepto([
    'ClaveProdServ' => '10317331',
    'NoIdentificacion' => 'UT421511',
    'Cantidad' => '24',
    'ClaveUnidad' => 'H87',
    'Unidad' => 'Pieza',
    'Descripcion' => 'Arreglo de 24 tulipanes rosadas recién cortados',
    'ValorUnitario' => '56.00',
    'Importe' => '1344.00',
    'Descuento' => '10.00',
]);

$concepto->add(new InformacionAduanera([
    'NumeroPedimento' => '00 00 0000 0000000',
]));

$cfdi->add($concepto);
```

```xml
<cfdi:Conceptos>
  <cfdi:Concepto ClaveProdServ="10317331" NoIdentificacion="UT421511" Cantidad="24" ClaveUnidad="H87" Unidad="Pieza" Descripcion="Arreglo de 24 tulipanes rosadas recién cortados" ValorUnitario="56.00" Importe="1344.00" Descuento="10.00">
    <cfdi:InformacionAduanera NumeroPedimento="00 00 0000 0000000"/>
  </cfdi:Concepto>
</cfdi:Conceptos>
```

### Cuenta Predial

En este nodo se puede expresar el número de cuenta predial con el que fue registrado el inmueble en el sistema catastral de la entidad federativa de que trate, o bien para incorporar los datos de identificación del certificado de participación inmobiliaria no amortizable.

```php
<?php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Concepto;
use PhpCfdi\CFDI\Node\CuentaPredial;

$cfdi = new CFDI([]);
$concepto = new Concepto();

$concepto->add(new CuentaPredial([
    'Numero' => '00000',
]));

$cfdi->add($concepto);
```

### Parte

En este nodo se pueden expresar las partes o componentes que integran la totalidad del concepto expresado en el comprobante fiscal digital por Internet.

```php
<?php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Concepto;
use PhpCfdi\CFDI\Node\Parte;

$cfdi = new CFDI([]);

$concepto = new Concepto([
    'ClaveProdServ' => '27113201',
    'NoIdentificacion' => 'UT421456',
    'Cantidad' => '1',
    'ClaveUnidad' => 'KT',
    'Unidad' => 'Kit',
    'Descripcion' => 'Kit de destornillador',
    'ValorUnitario' => '217.30',
    'Importe' => '217.30',
    'Descuento' => '0.00',
]);

$tornillo = new Parte([
    'ClaveProdServ' => '31161500',
    'NoIdentificacion' => 'UT367898',
    'Cantidad' => '34',
    'ClaveUnidad' => 'H87',
    'Unidad' => 'Pieza',
    'Descripcion' => 'Tornillo',
    'ValorUnitario' => '00.20',
    'Importe' => '6.80',
]);

$tornilloPerno = new Parte([
    'ClaveProdServ' => '31161501',
    'NoIdentificacion' => 'UT367899',
    'Cantidad' => '14',
    'ClaveUnidad' => 'H87',
    'Unidad' => 'Pieza',
    'Descripcion' => 'Tornillo de Perno',
    'ValorUnitario' => '00.75',
    'Importe' => '10.50',
]);

$destornillador = new Parte([
    'ClaveProdServ' => '27111701',
    'NoIdentificacion' => 'UT367900',
    'Cantidad' => '2',
    'ClaveUnidad' => 'H87',
    'Unidad' => 'Pieza',
    'Descripcion' => 'Destornillador',
    'ValorUnitario' => '100.00',
    'Importe' => '200.00',
]);

$concepto->add($tornillo);
$concepto->add($tornilloPerno);
$concepto->add($destornillador);

$cfdi->add($concepto);
```

```xml
<cfdi:Conceptos>
  <cfdi:Concepto ClaveProdServ="27113201" NoIdentificacion="UT421456" Cantidad="1" ClaveUnidad="KT" Unidad="Kit" Descripcion="Kit de destornillador" ValorUnitario="217.30" Importe="217.30" Descuento="0.00">
    <cfdi:Parte ClaveProdServ="31161500" NoIdentificacion="UT367898" Cantidad="34" ClaveUnidad="H87" Unidad="Pieza" Descripcion="Tornillo" ValorUnitario="00.20" Importe="6.80"/>
    <cfdi:Parte ClaveProdServ="31161501" NoIdentificacion="UT367899" Cantidad="14" ClaveUnidad="H87" Unidad="Pieza" Descripcion="Tornillo de Perno" ValorUnitario="00.75" Importe="10.50"/>
    <cfdi:Parte ClaveProdServ="27111701" NoIdentificacion="UT367900" Cantidad="2" ClaveUnidad="H87" Unidad="Pieza" Descripcion="Destornillador" ValorUnitario="100.00" Importe="200.00"/>
  </cfdi:Concepto>
</cfdi:Conceptos>
```
#Complementos


----------

### Pago

```php
<?php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Complemento\Pagos\Pago;

$cfdi = new CFDI([]);

$cfdi->add(new Pago([
    'FechaPago' => '2017-01-01T12:00:00',
    'FormaDePagoP' => '01',
    'MonedaP' => 'USD',
    'TipoCambioP' => '21.00',
    'Monto' => '123.45',
    'NumOperacion' => '83755',
    'RfcEmisorCtaOrd' => 'AAA010101AAA',
    'NomBancoOrdExt' => 'Banco de Jakarta',
    'CtaOrdenante' => '0319849245',
    'RfcEmisorCtaBen' => 'BCO010101AAA',
    'CtaBeneficiario' => '0453946620',
    'TipoCadPago' => '01',
    'CertPago' => 'por confirmar como vamos a proceder con esto',
    'CadPago' => 'por confirmar como vamos a proceder con esto',
    'SelloPago' => 'por confirmar como vamos a proceder con esto',
]));
```

#####Documento relacionado

```php
<?php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Complemento\Pagos\Pago;
use PhpCfdi\CFDI\Node\Complemento\Pagos\DoctoRelacionado;

$cfdi = new CFDI([]);
$pago = new Pago();

$pago->add(new DoctoRelacionado([
    'IdDocumento' => '11111111-6EF0-4526-8962-2A5E8C040A6C',
    'Serie' => 'ABC',
    'Folio' => '123',
    'MonedaDR' => 'USD',
    'TipoCambioDR' => '21.00',
    'MetodoDePagoDR' => 'PUE',
    'NumParcialidad' => '2',
    'ImpSaldoAnt' => '123.45',
    'ImpPagado' => '123.45',
    'ImpSaldoInsoluto' => '123.45',
]));

$cfdi->add($pago);
```

#####Traslado en pago

```php
<?php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Complemento\Pagos\Pago;
use PhpCfdi\CFDI\Node\Complemento\Pagos\Impuesto\Traslado;

$cfdi = new CFDI([]);
$pago = new Pago();

$pago->add(new Traslado([
    'Impuesto' => '001',
    'TipoFactor' => 'Tasa',
    'TasaOCuota' => '0.160000',
    'Importe' => '23000',
]));

$cfdi->add($pago);
```

#####Retención en pago

```php
<?php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Complemento\Pagos\Pago;
use PhpCfdi\CFDI\Node\Complemento\Pagos\Impuesto\Retencion;

$cfdi = new CFDI([]);
$pago = new Pago();

$pago->add(new Retencion([
    'Impuesto' => '001',
    'Importe' => '23000',
]));

$cfdi->add($pago);
```


## XmlResolver

De manera predeterminada, para construir la cadena de origen se usa el mecanismo recomendado por el SAT
de convertir el XML en texto usando XSLT desde el archivo remoto
`http://www.sat.gob.mx/sitio_internet/cfd/3/cadenaoriginal_3_3/cadenaoriginal_3_3.xslt`

Si desea descargar recursivamente los recursos del SAT para almacenarlos localmente puede usar un objeto
`XmlResolver` e insertarlo en su objeto `CFDI`, así puede especificar el lugar donde se van a descargar
y reutilizar los archivos XSLT del SAT.

```php
<?php
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\XmlResolver;

// no usará almacenamiento local
$resolver = new XmlResolver('');

// usará la ruta donde está instalada la librería + /build/resources/
$resolver = new XmlResolver();

// usará la ruta especificada
$resolver = new XmlResolver('/cfdi/cache/');

// establezca el objeto en el cfdi después de ser creado
/** @var CFDI $cfdi */
$cfdi->setResolver($resolver);

// también lo puede establecer desde el momento de su construcción
$cfdi = new CFDI([], $resolver);
```

Si se encuentra detrás de un proxy o quiere usar sus propios métodos de descarga puede implementar
la interfaz `XmlResourceRetriever\Downloader\DownloaderInterface` y establecérsela a su objeto `XmlResolver`

## Contribuciones

¡Sus contribuciones son bienvenidas! Por favor lea el archivo [CONTRIBUTING][] para más detalles.
No olvides también revisar los archivos [CHANGELOG][] y [TODO][].

## Licencia

La librería eclipxe/cfdi tiene copyright © Carlos C Soto y está bajo la licencia MIT. 
Ver el archivo de [Licencia](LICENSE) para más información.

Los derechos de autor de algunas porciones de este proyecto pertenecen a Orlando Charles <me@orlandocharles.com>, 2017
como parte del proyecto orlandocharles/cfdi (https://github.com/orlandocharles/cfdi) con licencia MIT.


[contributing]: https://github.com/eclipxe13/CfdiUtils/blob/master/CONTRIBUTING.md
[changelog]: https://github.com/eclipxe13/CfdiUtils/blob/master/docs/CHANGELOG.md
[todo]: https://github.com/eclipxe13/CfdiUtils/blob/master/docs/TODO.md

[source]: https://github.com/eclipxe13/cfdi
[release]: https://github.com/eclipxe13/cfdi/releases
[license]: https://github.com/eclipxe13/cfdi/blob/master/LICENSE
[build]: https://travis-ci.org/eclipxe13/cfdi?branch=master
[quality]: https://scrutinizer-ci.com/g/eclipxe13/cfdi/
[sensiolabs]: https://insight.sensiolabs.com/projects/ffa9eb49-58e3-4532-acdd-f8089d46ad73
[coverage]: https://scrutinizer-ci.com/g/eclipxe13/cfdi/code-structure/master/code-coverage
[downloads]: https://packagist.org/packages/eclipxe/cfdi

[badge-source]: http://img.shields.io/badge/source-eclipxe13/cfdi-blue.svg?style=flat-square
[badge-release]: https://img.shields.io/github/release/eclipxe13/cfdi.svg?style=flat-square
[badge-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[badge-build]: https://img.shields.io/travis/eclipxe13/cfdi/master.svg?style=flat-square
[badge-quality]: https://img.shields.io/scrutinizer/g/eclipxe13/cfdi/master.svg?style=flat-square
[badge-sensiolabs]: https://insight.sensiolabs.com/projects/ffa9eb49-58e3-4532-acdd-f8089d46ad73/mini.png
[badge-coverage]: https://img.shields.io/scrutinizer/coverage/g/eclipxe13/cfdi/master.svg?style=flat-square
[badge-downloads]: https://img.shields.io/packagist/dt/eclipxe/cfdi.svg?style=flat-square

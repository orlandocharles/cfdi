<xsl:stylesheet version = '1.0'
    xmlns:xsl='http://www.w3.org/1999/XSL/Transform'
    xmlns:cfdi='http://www.sat.gob.mx/cfd/3'>

<xsl:output method = "html" /> 

<xsl:template match="//cfdi:Comprobante">
   <html>
   <head>
   <link rel="STYLESHEET" media="screen" type="text/css" href="factura.css"/>
   <title>Factura Electronica <xsl:value-of select="@serie"/><xsl:value-of select="@folio"/></title>
   </head>
   <body>
   <table width="100%" border="1">
      <tr><td colspan="2" align="right">
          <table border="1">
               <tr><th class="h1">Serie</th><td class="h1"><xsl:value-of select="@serie"/></td></tr>
               <tr><th class="h1">Folio</th><td class="h1"><xsl:value-of select="@folio"/></td></tr>
               <tr><th class="h1">Fecha</th><td class="h1"><xsl:value-of select="@fecha"/></td></tr>
           </table>
           </td>
           </tr>
      <tr><td width="50%">
           <table width="100%" border="1"><tr><th colspan="2" class="h1">Emisor</th></tr>
               <tr><th>RFC</th><td><xsl:value-of select="cfdi:Emisor/@rfc"/></td></tr>
               <tr><th>Nombre</th><td><xsl:value-of select="cfdi:Emisor/@nombre"/></td></tr>
                <xsl:apply-templates select="//cfdi:DomicilioFiscal"/>

             </table>
          </td>
          <td>
          <table width="100%" border="1"><tr><th colspan="2" class="h1">Receptor</th></tr>
             <tr><th>RFC</th><td><xsl:value-of select="cfdi:Receptor/@rfc"/></td></tr>
             <tr><th>Nombre</th><td><xsl:value-of select="cfdi:Receptor/@nombre"/></td></tr>
             <xsl:apply-templates select="//cfdi:Domicilio"/>


           </table>
           </td>
         </tr>
         <tr><table width="100%" border="1">
             <tr><th>Cantidad</th>
                 <th>Descripcion</th>
                 <th>Precio</th>
                 <th>Importe</th>
             </tr>
             <xsl:apply-templates select="//cfdi:Concepto"/>
             <xsl:for-each select="Concepto">
             </xsl:for-each>

             <xsl:apply-templates select="//cfdi:Traslado"/>
            </table>
         </tr>
        </table>
        <hr/>
        <table width="100%" border="1">
            <tr><th>Numero de serie del Certificado</th></tr>
            <tr><td><xsl:value-of select="@noCertificado"/></td></tr>
            <tr><th>Sello Digital</th></tr>
            <tr><td><small><small><xsl:value-of select="@sello"/></small></small></td></tr>
        </table>
        <center>
        Este documento es una impresion de un comprobante fiscal digital por Internet
        </center>
    </body>
    </html>
</xsl:template>


<xsl:template match="//cfdi:DomicilioFiscal">
    <tr><th colspan="2" class="h2">Domicilio</th></tr>
    <tr><td colspan="2"><xsl:value-of select="@calle"/> # <xsl:value-of select="@noExterior"/> - <xsl:value-of select="@noInterior"/></td></tr>
    <tr><td colspan="2"><xsl:value-of select="@colonia"/></td></tr>
    <tr><td colspan="2"><xsl:value-of select="@localidad"/></td></tr>
    <tr><td colspan="2"><xsl:value-of select="@referencia"/></td></tr>
    <tr><td colspan="2"><xsl:value-of select="@municipio"/>
    <xsl:if test="@codigoPostal"> CODIGO POSTAL <xsl:value-of select="@codigoPostal"/></xsl:if>
         </td></tr>
     <tr><td colspan="2"><xsl:value-of select="@estado"/></td></tr>
     <tr><td colspan="2"><xsl:value-of select="@pais"/></td></tr>
</xsl:template>

<xsl:template match="//cfdi:Domicilio">
    <tr><th colspan="2" class="h2">Domicilio</th></tr>
    <tr><td colspan="2"><xsl:value-of select="@calle"/> # <xsl:value-of select="@noExterior"/> - <xsl:value-of select="@noInterior"/></td></tr>
    <tr><td colspan="2"><xsl:value-of select="@colonia"/></td></tr>
    <tr><td colspan="2"><xsl:value-of select="@localidad"/></td></tr>
    <tr><td colspan="2"><xsl:value-of select="@referencia"/></td></tr>
    <tr><td colspan="2"><xsl:value-of select="@municipio"/>
        <xsl:if test="@codigoPostal"> CODIGO POSTAL <xsl:value-of select="@codigoPostal"/></xsl:if>
        </td></tr>
    <tr><td colspan="2"><xsl:value-of select="@estado"/></td></tr>
    <tr><td colspan="2"><xsl:value-of select="@pais"/></td></tr>
</xsl:template>

<xsl:template match="//cfdi:Concepto">
    <tr><td align="center"><xsl:value-of select="@cantidad"/></td>
        <td><xsl:value-of select="@descripcion"/></td>
        <td align="right"><xsl:value-of select="@valorUnitario"/></td>
        <td align="right"><xsl:value-of select="@importe"/></td>
    </tr>
</xsl:template>

<xsl:template match="//cfdi:Traslado">
    <tr><td colspan="2" align="right"><xsl:value-of select="@impuesto"/></td>
        <td align="right"><xsl:value-of select="@importe"/></td>
        <td><xsl:value-of select="@tasa"/> %</td>
    </tr>
</xsl:template>

</xsl:stylesheet>

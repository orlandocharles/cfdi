<xsl:stylesheet version = '1.0'
    xmlns:xsl='http://www.w3.org/1999/XSL/Transform'
    xmlns:cfdi="http://www.sat.gob.mx/cfd/3">
<xsl:output method = "text" /> 
<xsl:template match="cfdi:Comprobante">
      <xsl:value-of select="@sello"/>
</xsl:template>
</xsl:stylesheet>

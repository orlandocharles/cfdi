<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:fn="http://www.w3.org/2005/xpath-functions" xmlns:operacionesconderivados="http://www.sat.gob.mx/esquemas/retencionpago/1/operacionesconderivados">

  <!-- Con el siguiente método se establece que la salida deberá ser en texto -->
  <xsl:output method="text" version="1.0" encoding="UTF-8" indent="no"/>
  
  <!--  Aquí iniciamos el procesamiento de los datos incluidos en Operacionesconderivados -->
  <xsl:template match="operacionesconderivados:Operacionesconderivados">
    <!-- Iniciamos el tratamiento de los atributos de Operacionesconderivados -->
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@Version"/>
    </xsl:call-template>
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@MontGanAcum"/>
    </xsl:call-template>
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@MontPerdDed"/>
    </xsl:call-template>
  </xsl:template>     
</xsl:stylesheet>

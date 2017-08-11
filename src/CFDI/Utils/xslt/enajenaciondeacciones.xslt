<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:fn="http://www.w3.org/2005/xpath-functions" xmlns:enajenaciondeacciones="http://www.sat.gob.mx/esquemas/retencionpago/1/enajenaciondeacciones">

  <!-- Con el siguiente método se establece que la salida deberá ser en texto -->
  <xsl:output method="text" version="1.0" encoding="UTF-8" indent="no"/>
 
  <!--  Aquí iniciamos el procesamiento de los datos incluidos en EnajenaciondeAcciones -->
  <xsl:template match="enajenaciondeacciones:EnajenaciondeAcciones">
    <!-- Iniciamos el tratamiento de los atributos de EnajenaciondeAcciones -->
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@Version"/>
    </xsl:call-template>
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@ContratoIntermediacion"/>
    </xsl:call-template>
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@Ganancia"/>
    </xsl:call-template>
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@Perdida"/>
    </xsl:call-template>    
  </xsl:template>  
</xsl:stylesheet>

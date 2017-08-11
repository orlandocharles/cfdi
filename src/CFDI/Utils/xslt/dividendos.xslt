<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:fn="http://www.w3.org/2005/xpath-functions" xmlns:dividendos="http://www.sat.gob.mx/esquemas/retencionpago/1/dividendos">

  <!-- Con el siguiente método se establece que la salida deberá ser en texto -->
  <xsl:output method="text" version="1.0" encoding="UTF-8" indent="no"/>
  
  <!--  Aquí iniciamos el procesamiento de los datos incluidos en Dividendos-->
  <xsl:template match="dividendos:Dividendos">
    <!-- Iniciamos el tratamiento de los atributos de Dividendos -->
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@Version"/>
    </xsl:call-template>
    <!--
			Llamadas para procesar al los sub nodos de Dividendos
		-->
    <xsl:apply-templates select="./dividendos:DividOUtil"/>
    <xsl:apply-templates select="./dividendos:Remanente"/>
  </xsl:template>
  <!-- Manejador de nodos tipo DividOUtil -->
  <xsl:template match="dividendos:DividOUtil">
    <!-- Iniciamos el tratamiento de los atributos DividOUtil -->
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@CveTipDivOUtil"/>
    </xsl:call-template>
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@MontISRAcredRetMexico"/>
    </xsl:call-template>
        <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@MontISRAcredRetExtranjero"/>
    </xsl:call-template>
    <xsl:call-template name="Opcional">
      <xsl:with-param name="valor" select="./@MontRetExtDivExt"/>
    </xsl:call-template>
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@TipoSocDistrDiv"/>
    </xsl:call-template>
    <xsl:call-template name="Opcional">
      <xsl:with-param name="valor" select="./@MontISRAcredNal"/>
    </xsl:call-template>
    <xsl:call-template name="Opcional">
      <xsl:with-param name="valor" select="./@MontDivAcumNal"/>
    </xsl:call-template>
    <xsl:call-template name="Opcional">
      <xsl:with-param name="valor" select="./@MontDivAcumExt"/>
    </xsl:call-template>
    </xsl:template>
  <!-- Manejador de nodos tipo Receptor -->
  <xsl:template match="dividendos:Remanente">
    <!-- Iniciamos el tratamiento de los atributos del Remanente -->
    <xsl:call-template name="Opcional">
      <xsl:with-param name="valor" select="./@ProporcionRem"/>
    </xsl:call-template>
  </xsl:template>  
</xsl:stylesheet>

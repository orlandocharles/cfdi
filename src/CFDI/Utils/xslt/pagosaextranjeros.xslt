<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:fn="http://www.w3.org/2005/xpath-functions" xmlns:pagosaextranjeros="http://www.sat.gob.mx/esquemas/retencionpago/1/pagosaextranjeros">

  <!-- Con el siguiente método se establece que la salida deberá ser en texto -->
  <xsl:output method="text" version="1.0" encoding="UTF-8" indent="no"/>
  
  <!--  Aquí iniciamos el procesamiento de los datos incluidos en Pagosaextranjeros -->
  <xsl:template match="pagosaextranjeros:Pagosaextranjeros">
    <!-- Iniciamos el tratamiento de los atributos de Pagosaextranjeros -->
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@Version"/>
    </xsl:call-template>
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@EsBenefEfectDelCobro"/>
    </xsl:call-template>
      
    <!--
			Llamadas para procesar al los sub nodos de Pagosaextranjeros
		-->
    <xsl:apply-templates select="./pagosaextranjeros:NoBeneficiario"/>
    <xsl:apply-templates select="./pagosaextranjeros:Beneficiario"/>
  </xsl:template>
  <!-- Manejador de nodos tipo NoBeneficiario -->
  <xsl:template match="pagosaextranjeros:NoBeneficiario">
    <!-- Iniciamos el tratamiento de los atributos del NoBeneficiario -->
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@PaisDeResidParaEfecFisc"/>
    </xsl:call-template>
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@ConceptoPago"/>
    </xsl:call-template>
        <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@DescripcionConcepto"/>
    </xsl:call-template>
    </xsl:template>
  <!-- Manejador de nodos tipo Beneficiario -->
   <xsl:template match="pagosaextranjeros:Beneficiario">
    <!-- Iniciamos el tratamiento de los atributos de Beneficiario -->
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@RFC"/>
    </xsl:call-template>
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@CURP"/>
    </xsl:call-template>
        <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@NomDenRazSocB"/>
    </xsl:call-template>
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@ConceptoPago"/>
    </xsl:call-template>
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@DescripcionConcepto"/>
    </xsl:call-template>
    </xsl:template>      
</xsl:stylesheet>

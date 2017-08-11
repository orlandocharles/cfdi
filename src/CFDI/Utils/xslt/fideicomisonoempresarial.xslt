<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:fn="http://www.w3.org/2005/xpath-functions" xmlns:fideicomisonoempresarial="http://www.sat.gob.mx/esquemas/retencionpago/1/fideicomisonoempresarial">

  <!-- Con el siguiente método se establece que la salida deberá ser en texto -->
  <xsl:output method="text" version="1.0" encoding="UTF-8" indent="no"/>
  
   <!--  Aquí iniciamos el procesamiento de los datos incluidos en Fideicomisonoempresarial -->
  <xsl:template match="fideicomisonoempresarial:Fideicomisonoempresarial">
    <!-- Iniciamos el tratamiento de los atributos de Fideicomisonoempresarial -->
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@Version"/>
    </xsl:call-template>    
    <!--
			Llamadas para procesar al los sub nodos de Fideicomisonoempresarial
		-->
    <xsl:apply-templates select="./fideicomisonoempresarial:IngresosOEntradas"/>
    <xsl:apply-templates select="./fideicomisonoempresarial:DeduccOSalidas"/>
    <xsl:apply-templates select="./fideicomisonoempresarial:RetEfectFideicomiso"/>
  </xsl:template>
  <!-- Manejador de nodos tipo IngresosOEntradas -->
  <xsl:template match="fideicomisonoempresarial:IngresosOEntradas">
    <!-- Iniciamos el tratamiento de los atributos del Emisor -->
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@MontTotEntradasPeriodo"/>
    </xsl:call-template>
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@PartPropAcumDelFideicom"/>
    </xsl:call-template>
        <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@PropDelMontTot"/>
    </xsl:call-template>
    <xsl:if test="./fideicomisonoempresarial:IntegracIngresos">
      <xsl:call-template name="Requerido">
        <xsl:with-param name="valor" select="./fideicomisonoempresarial:IntegracIngresos/@Concepto"/>
      </xsl:call-template>
    </xsl:if>
    </xsl:template>
  <!-- Manejador de nodos tipo DeduccOSalidas -->
  <xsl:template match="fideicomisonoempresarial:DeduccOSalidas">
    <!-- Iniciamos el tratamiento de los atributos de DeduccOSalidas -->
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@MontTotEgresPeriodo"/>
    </xsl:call-template>
     <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@PartPropDelFideicom"/>
    </xsl:call-template>
     <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@PropDelMontTot"/>     
    </xsl:call-template>
    <xsl:if test="./fideicomisonoempresarial:IntegracEgresos">
      <xsl:call-template name="Requerido">
        <xsl:with-param name="valor" select="./fideicomisonoempresarial:IntegracEgresos/@ConceptoS"/>
      </xsl:call-template>
    </xsl:if>   
  </xsl:template>
  <!-- Manejador de nodos tipo RetEfectFideicomiso -->
  <xsl:template match="fideicomisonoempresarial:RetEfectFideicomiso">
    <!-- Iniciamos el tratamiento de los atributos de RetEfectFideicomiso -->
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@MontRetRelPagFideic"/>
    </xsl:call-template>
    <xsl:call-template name="Requerido">
      <xsl:with-param name="valor" select="./@DescRetRelPagFideic"/>
    </xsl:call-template>        
    </xsl:template>
</xsl:stylesheet>

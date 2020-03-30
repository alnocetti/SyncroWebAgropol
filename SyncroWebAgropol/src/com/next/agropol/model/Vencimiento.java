package com.next.agropol.model;

public class Vencimiento {

	private String Cuenta;
	private int Moneda;
	private int Comprobante;
	private String Vencimiento;
	private String Fecha;
	private String Codigo;
	private String NumeroComprobante;
	private String Contrato;
	private String Boleto;
	private String RazonSocial;
	private float ImporteOriginal;
	private float Saldo;
	private float Iva;
	private float ImporteNeto;
	
	public String getCuenta() {
		return Cuenta;
	}
	public void setCuenta(String cuenta) {
		Cuenta = cuenta;
	}
	public int getMoneda() {
		return Moneda;
	}
	public void setMoneda(int moneda) {
		Moneda = moneda;
	}
	public int getComprobante() {
		return Comprobante;
	}
	public void setComprobante(int comprobante) {
		Comprobante = comprobante;
	}
	public String getVencimiento() {
		return Vencimiento;
	}
	public void setVencimiento(String vencimiento) {
		Vencimiento = vencimiento;
	}
	public String getFecha() {
		return Fecha;
	}
	public void setFecha(String fecha) {
		Fecha = fecha;
	}
	public String getCodigo() {
		return Codigo;
	}
	public void setCodigo(String codigo) {
		Codigo = codigo;
	}
	public String getNumeroComprobante() {
		return NumeroComprobante;
	}
	public void setNumeroComprobante(String numeroComprobante) {
		NumeroComprobante = numeroComprobante;
	}
	public String getContrato() {
		return Contrato;
	}
	public void setContrato(String contrato) {
		Contrato = contrato;
	}
	public String getBoleto() {
		return Boleto;
	}
	public void setBoleto(String boleto) {
		Boleto = boleto;
	}
	public String getRazonSocial() {
		return RazonSocial;
	}
	public void setRazonSocial(String razonSocial) {
		RazonSocial = razonSocial;
	}
	public float getImporteOriginal() {
		return ImporteOriginal;
	}
	public void setImporteOriginal(float importeOriginal) {
		ImporteOriginal = importeOriginal;
	}
	public float getSaldo() {
		return Saldo;
	}
	public void setSaldo(float saldo) {
		Saldo = saldo;
	}
	public float getIva() {
		return Iva;
	}
	public void setIva(float iva) {
		Iva = iva;
	}
	public float getImporteNeto() {
		return ImporteNeto;
	}
	public void setImporteNeto(float importeNeto) {
		ImporteNeto = importeNeto;
	}
	
}

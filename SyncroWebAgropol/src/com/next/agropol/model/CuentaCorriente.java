package com.next.agropol.model;

public class CuentaCorriente {
	
	private String Cuenta;
	private int Moneda;
	private String Fecha;
	private String Referencia;
	private boolean DebeHaber;
	private float Saldo;
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
	public String getFecha() {
		return Fecha;
	}
	public void setFecha(String fecha) {
		Fecha = fecha;
	}
	public String getReferencia() {
		return Referencia;
	}
	public void setReferencia(String referencia) {
		Referencia = referencia;
	}
	public boolean isDebeHaber() {
		return DebeHaber;
	}
	public void setDebeHaber(boolean debeHaber) {
		DebeHaber = debeHaber;
	}
	public float getSaldo() {
		return Saldo;
	}
	public void setSaldo(float saldo) {
		Saldo = saldo;
	}
	
	
	
}

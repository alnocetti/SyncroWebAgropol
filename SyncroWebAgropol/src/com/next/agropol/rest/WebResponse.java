package com.next.agropol.rest;

public class WebResponse {
	
	private String NombreArchivo;
	private String MensajeArchivo;
	private String Mensaje;
	private String ResponseMessage;
	private int ResponseCode;

	public WebResponse() {
		super();
		// TODO Auto-generated constructor stub
	}

	public String getNombreArchivo() {
		return NombreArchivo;
	}

	public void setNombreArchivo(String nombreArchivo) {
		NombreArchivo = nombreArchivo;
	}

	public String getMensajeArchivo() {
		return MensajeArchivo;
	}

	public void setMensajeArchivo(String mensajeArchivo) {
		MensajeArchivo = mensajeArchivo;
	}

	public String getMensaje() {
		return Mensaje;
	}

	public void setMensaje(String mensaje) {
		Mensaje = mensaje;
	}

	public int getResponseCode() {
		return ResponseCode;
	}

	public void setResponseCode(int responseCode) {
		ResponseCode = responseCode;
	}

	public String getResponseMessage() {
		return ResponseMessage;
	}

	public void setResponseMessage(String responseMessage) {
		ResponseMessage = responseMessage;
	}
	
	

}

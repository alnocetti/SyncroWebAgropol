package com.next.agropol.reader;

import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.List;

import com.linuxense.javadbf.DBFReader;
import com.linuxense.javadbf.DBFRow;
import com.linuxense.javadbf.DBFUtils;
import com.next.agropol.main.Application;
import com.next.agropol.model.Analisis;
import com.next.agropol.model.Comprobante;
import com.next.agropol.model.Contrato;
import com.next.agropol.model.Cuenta;
import com.next.agropol.model.CuentaCorriente;
import com.next.agropol.model.Descarga;
import com.next.agropol.model.Producto;
import com.next.agropol.model.Puerto;
import com.next.agropol.model.Vencimiento;
import com.next.agropol.utils.Utils;

public class Reader {
	
	private DBFReader reader;
	String original = "��������������������������������������������������������������";
    String ascii = "AAAAAAACEEEEIIIIDNOOOOOOUUUUYBaaaaaaaceeeeiiiionoooooouuuuyyN�";
	SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd");

	public Reader() {
		super();
		this.reader = null;
	}
	
	public List<CuentaCorriente> readCuentasCorrientes() {
				
		List<CuentaCorriente> respuesta = new ArrayList<CuentaCorriente>();
		
		reader = null;
		
		try {
			
			reader = new DBFReader(new FileInputStream(Application.DIR_LECTURA + "wbmovim.dbf"));
			
			DBFRow row;
			
			while((row = reader.nextRow()) != null) {
				
				CuentaCorriente cc = new CuentaCorriente();
				
				cc.setCuenta(row.getString("movcliente"));
				
				cc.setDebeHaber(row.getFloat("movimporte") < 0 ? false : true);
				
				if (row.getDate("movvto") != null)
				cc.setFecha(format.format(row.getDate("movvto")));
				
				cc.setMoneda(row.getInt("movcambio") == 0 ? 1 : 2);
				
				String output = row.getString("movreferen");
			    for (int i=0; i<original.length(); i++) {
			    	
			            output = output.replace(original.charAt(i), ascii.charAt(i));
			            
			            }
				
				cc.setReferencia(output);
				
				cc.setSaldo(row.getFloat("movimporte"));
				
				respuesta.add(cc);
				
			}
			
			DBFUtils.close(reader);
			
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
			
		return respuesta;
		
	}
	
	public List<Vencimiento> readVencimientos(){
				
		List<Vencimiento> respuesta = new ArrayList<Vencimiento>();
		
		reader = null;
		
		try {
			
			reader = new DBFReader(new FileInputStream(Application.DIR_LECTURA + "wbvencim.dbf"));
			
			DBFRow row;
			
			while((row = reader.nextRow()) != null) {
				
				Vencimiento vencimiento = new Vencimiento();
				
				vencimiento.setBoleto(row.getString("venboleto"));
				
				vencimiento.setCodigo(row.getString("vencodigo"));
				
				vencimiento.setNumeroComprobante(row.getString("ventipcmp") + "-" +row.getString("vensucur") + "-" + row.getString("vennumero"));
				
				vencimiento.setContrato(row.getString("venslip"));
				
				vencimiento.setCuenta(row.getString("vencuenta"));
				
				if (row.getDate("venfecha") != null)
				vencimiento.setFecha(format.format(row.getDate("venfecha")));

				vencimiento.setImporteNeto(row.getFloat("venneto"));
				
				vencimiento.setImporteOriginal(row.getFloat("venimporte"));
				
				vencimiento.setIva(row.getFloat("veniva"));
				
				vencimiento.setMoneda(row.getInt("vencambio") == 0 ? 1 : 2);
				
				int comprobante = 0;
				
				switch(row.getInt("vencodigo")) {
				
				case 1:
					comprobante = 1;
					break;
				case 10:
					comprobante = 2;
					break;
				case 20:
					comprobante = 3;
					break;
				case 50:
					comprobante = 4;
					break;
				case 60:
					comprobante = 5;
					break;
				}
				vencimiento.setComprobante(comprobante);
				
				String output = row.getString("venotranom");
			    for (int i=0; i<original.length(); i++) {
			    	
			            output = output.replace(original.charAt(i), ascii.charAt(i));
			       
			            }
				vencimiento.setRazonSocial(output);
							
				vencimiento.setSaldo(row.getFloat("vensaldo"));
				
				vencimiento.setVencimiento(format.format(row.getDate("venvto")));
				
				respuesta.add(vencimiento);
				
			}
			
			DBFUtils.close(reader);
			
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
			
		return respuesta;
		
	}
	
	public List<Contrato> readContratos(){
		
		List<Contrato> respuesta = new ArrayList<Contrato>();
		
		reader = null;
		
		try {
			
			reader = new DBFReader(new FileInputStream(Application.DIR_LECTURA + "wbslip.dbf"));
			
			DBFRow row;
			
			while((row = reader.nextRow()) != null) {
				
				// Para vendedor
				
				Contrato contrato = new Contrato();
				
				contrato.setCantidad(row.getInt("sltotkilos"));
				
				contrato.setCantidadTexto(Utils.cantidadConLetra(row.getString("sltotkilos")));
				
				contrato.setComprador(Integer.parseInt(row.getString("slcodcompr")));
				
				contrato.setCondiciones(row.getString("sltipodesc"));
				
				contrato.setContrato(row.getString("slnumero"));
				
				contrato.setCosecha(row.getString("slcosecha"));
				
				contrato.setCuenta(row.getString("slcodvende"));
				
				contrato.setDestino(row.getInt("slprvdesti"));
				
				if (row.getDate("slfecha") != null)
				contrato.setFecha(format.format(row.getDate("slfecha")));
				
				if (row.getDate("slentrehas") != null) {
					contrato.setFechaFin(format.format(row.getDate("slentrehas")));
				}else {
					contrato.setFecha("");
				}
				
				if (row.getDate("slentredes") != null) {
					contrato.setFechaInincio(format.format(row.getDate("slentredes")));
				}else {
					contrato.setFechaInincio("");
				}
				
				if (row.getDate("slpagoel") != null) {
					contrato.setFechaPago(format.format(row.getDate("slpagoel")));
				}else {
					contrato.setFechaPago("");
				}
				
				contrato.setFormaPago(row.getString("slformapag"));
				
				contrato.setMoneda(row.getInt("slmoneda") == 0 ? 1 : 2);
				
				contrato.setOperacion(row.getString("slnomboper"));
				
				contrato.setPrecio(row.getFloat("slprecio"));
				
				contrato.setProcedencia(row.getInt("slprvproce"));
				
				contrato.setProducto(Integer.parseInt(row.getString("slcereal")));
				
				contrato.setPuerto(row.getInt("slpuerto"));
				
				contrato.setPuestoSobre(row.getString("slpuesnomb"));
				
				contrato.setTipo(row.getInt("sltipocere"));
				
				contrato.setVendedor(Integer.parseInt(row.getString("slcodvende")));
				
				contrato.setVenta(row.getString("sldesventa"));
				
				contrato.setNumeroComprador(row.getString("slboleto"));
				
				respuesta.add(contrato);
								

				// Para comprador
				
				Contrato contrato1 = new Contrato();
				
				contrato1.setCantidad(row.getInt("sltotkilos"));
				
				contrato1.setCantidadTexto(Utils.cantidadConLetra(row.getString("sltotkilos")));
				
				contrato1.setComprador(Integer.parseInt(row.getString("slcodcompr")));
				
				contrato1.setCondiciones(row.getString("sltipodesc"));
				
				contrato1.setContrato(row.getString("slnumero"));
				
				contrato1.setCosecha(row.getString("slcosecha"));
				
				contrato1.setCuenta(row.getString("slcodcompr"));
				
				contrato1.setDestino(row.getInt("slprvdesti"));
				
				if (row.getDate("slfecha") != null)
				contrato1.setFecha(format.format(row.getDate("slfecha")));
				
				if (row.getDate("slentrehas") != null) {
					contrato1.setFechaFin(format.format(row.getDate("slentrehas")));
				}else {
					contrato1.setFechaFin("");
				}
				
				if (row.getDate("slentredes") != null) {
					contrato1.setFechaInincio(format.format(row.getDate("slentredes")));
				}else {
					contrato1.setFechaInicio("");
				}
				
				if (row.getDate("slpagoel") != null) {
					contrato1.setFechaPago(format.format(row.getDate("slpagoel")));
				}else {
					contrato1.setFechaPago("");
				}
				
				contrato1.setFormaPago(row.getString("slformapag"));
				
				contrato1.setMoneda(row.getInt("slmoneda") == 0 ? 1 : 2);
				
				contrato1.setOperacion(row.getString("slnomboper"));
				
				contrato1.setPrecio(row.getFloat("slprecio"));
				
				contrato1.setProcedencia(row.getInt("slprvproce"));
				
				contrato1.setProducto(Integer.parseInt(row.getString("slcereal")));
				
				contrato1.setPuerto(row.getInt("slpuerto"));
				
				contrato1.setPuestoSobre(row.getString("slpuesnomb"));
				
				contrato1.setTipo(row.getInt("sltipocere"));
				
				contrato1.setVendedor(Integer.parseInt(row.getString("slcodvende")));
				
				contrato1.setVenta(row.getString("sldesventa"));
				
				contrato1.setNumeroComprador(row.getString("slboleto"));
				
				respuesta.add(contrato1);
				
			}
			
			DBFUtils.close(reader);
			
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
			
		return respuesta;
		
	}
	
	public List<Descarga> readDescargas(){
		
		List<Descarga> respuesta = new ArrayList<Descarga>();
		
		reader = null;
		
		try {
			
			reader = new DBFReader(new FileInputStream(Application.DIR_LECTURA + "wbdescar.dbf"));
			
			DBFRow row;
			
			while((row = reader.nextRow()) != null) {
				
				// Para vendedor
				
				Descarga descarga = new Descarga();
				
				descarga.setContrato(row.getString("desnroslip"));
				
				descarga.setCPorte(row.getInt("desnporte"));
				
				descarga.setCuenta(row.getString("desvende"));
				
				if(row.getDate("desfecha") != null)
				descarga.setFecha(format.format(row.getDate("desfecha")));
				
				descarga.setKilos(row.getInt("deskgdesca"));
				
				descarga.setMerma(row.getInt("deskgmerma"));
				
				descarga.setNumero(row.getInt("desnumero"));
				
				//revisar envio descripcion
				descarga.setProcedencia(row.getString("desprocede"));
				
				descarga.setProducto(Integer.parseInt(row.getString("descereal")));
				
				descarga.setPuerto(row.getInt("despuerto"));

				respuesta.add(descarga);
				
				// Para comprador
				
				Descarga descarga1 = new Descarga();
				
				descarga1.setContrato(row.getString("desnroslip"));
				
				descarga1.setCPorte(row.getInt("desnporte"));
				
				descarga1.setCuenta(row.getString("descompr"));
				
				if(row.getDate("desfecha") != null)
				descarga1.setFecha(format.format(row.getDate("desfecha")));
				
				descarga1.setKilos(row.getInt("deskgdesca"));
				
				descarga1.setMerma(row.getInt("deskgmerma"));
				
				descarga1.setNumero(row.getInt("desnumero"));
				
				//revisar envio descripcion
				descarga1.setProcedencia(row.getString("desprocede"));
				
				descarga1.setProducto(Integer.parseInt(row.getString("descereal")));
				
				descarga1.setPuerto(row.getInt("despuerto"));

				respuesta.add(descarga1);
				
			}
			
			DBFUtils.close(reader);
			
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
			
		return respuesta;
		
	}
	
	public List<Analisis> readAnalisis(){
		
		List<Analisis> respuesta = new ArrayList<Analisis>();
		
		reader = null;
		
		try {
			
			reader = new DBFReader(new FileInputStream(Application.DIR_LECTURA + "wbanalis.dbf"));
			
			DBFRow row;
			
			while((row = reader.nextRow()) != null) {
				
				// Para vendedor
				
				Analisis analisis = new Analisis();
				
				analisis.setACargo(row.getFloat("anahoncomp"));
				
				analisis.setContrato(row.getString("ananroslip"));
				
				analisis.setCuenta(row.getString("anavende"));
				
				analisis.setDescripcion(row.getString("anaresdes"));
				
				analisis.setGrado(row.getString("anagrado"));
				
				analisis.setHonorarios(row.getFloat("anahontota"));
				
				analisis.setKilos(row.getInt("anakganali"));
				
				if (row.getString("anareslit").length() > 0)
				analisis.setLitros(Float.parseFloat(row.getString("anareslit")));
				
				analisis.setNumero(row.getInt("ananumero"));
				
				analisis.setPorcentaje(row.getFloat("anarespor"));
				
				if(row.getDate("anafecha") != null)
					analisis.setFecha(format.format(row.getDate("anafecha")));
				
				respuesta.add(analisis);
				
				// Para vendedor
				
				Analisis analisis1 = new Analisis();
				
				analisis1.setACargo(row.getFloat("anahoncomp"));
				
				analisis1.setContrato(row.getString("ananroslip"));
				
				analisis1.setCuenta(row.getString("anacompr"));
				
				analisis1.setDescripcion(row.getString("anaresdes"));
				
				analisis1.setGrado(row.getString("anagrado"));
				
				analisis1.setHonorarios(row.getFloat("anahontota"));
				
				analisis1.setKilos(row.getInt("anakganali"));
				
				if (row.getString("anareslit").length() > 0)
				analisis1.setLitros(Float.parseFloat(row.getString("anareslit")));
				
				analisis1.setNumero(row.getInt("ananumero"));
				
				analisis1.setPorcentaje(row.getFloat("anarespor"));
				
				respuesta.add(analisis1);
				
			}
			
			DBFUtils.close(reader);
			
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
			
		return respuesta;
		
	}
	
	public List<Comprobante> readComprobantes(){
		
		List<Comprobante> respuesta = new ArrayList<Comprobante>();
		
		reader = null;
		
		try {
			
			reader = new DBFReader(new FileInputStream(Application.DIR_LECTURA + "wbcptes.dbf"));
			
			DBFRow row;
			
			while((row = reader.nextRow()) != null) {
				
				// Para vendedor
				
				Comprobante comprobante = new Comprobante();
				
				int codigo = 0;
				
				switch(row.getInt("cabcodcpte")) {
				
				case 1:
					codigo = 1;
					break;
				case 10:
					codigo = 2;
					break;
				case 20:
					codigo = 3;
					break;
				case 50:
					codigo = 4;
					break;
				case 60:
					codigo = 5;
					break;
				}
				comprobante.setComprobante(codigo);
				
				comprobante.setContrato(row.getString("cabnroslip"));
				
				comprobante.setCuenta(row.getString("cabnrovend"));
				
				comprobante.setEmision(row.getString("cabptoemis"));
			
				comprobante.setFechaEmision(format.format(row.getDate("cabfecha")));
				
				comprobante.setFechaVencimiento(format.format(row.getDate("cabfechvto")));
				
				comprobante.setForm1116(row.getString("cabnro1116"));
				
				comprobante.setKilos(row.getInt("cabtotkilo"));
				
				comprobante.setNumero(row.getString("cabnumero"));
				
				comprobante.setTotal(row.getFloat("cabtotal"));
				
				respuesta.add(comprobante);
				
				// Para comprador
				
				Comprobante comprobante1 = new Comprobante();

				comprobante1.setComprobante(codigo);
				
				comprobante1.setContrato(row.getString("cabnroslip"));
				
				comprobante1.setCuenta(row.getString("cabnrocomp"));
				
				comprobante1.setEmision(row.getString("cabptoemis"));
			
				comprobante1.setFechaEmision(format.format(row.getDate("cabfecha")));
				
				comprobante1.setFechaVencimiento(format.format(row.getDate("cabfechvto")));
				
				comprobante1.setForm1116(row.getString("cabnro1116"));
				
				comprobante1.setKilos(row.getInt("cabtotkilo"));
				
				comprobante1.setNumero(row.getString("cabnumero"));
				
				comprobante1.setTotal(row.getFloat("cabtotal"));
				
				respuesta.add(comprobante1);
				
			}
			
			DBFUtils.close(reader);
			
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
			
		return respuesta;
		
	}
	
	public List<Cuenta> readCuentas(){
		
		List<Cuenta> respuesta = new ArrayList<Cuenta>();
		
		reader = null;
		
		try {
			
			reader = new DBFReader(new FileInputStream(Application.DIR_LECTURA + "wbcuenta.dbf"));
			
			DBFRow row;
			
			while((row = reader.nextRow()) != null) {
								
				Cuenta cuenta = new Cuenta();
				
				cuenta.setCodigo(row.getString("clicodigo"));
				
				String output = row.getString("clirazsoc");
			    for (int i=0; i<original.length(); i++) {
			    	
			            output = output.replace(original.charAt(i), ascii.charAt(i));
			       
			            }
				cuenta.setRazonSocial(output);
								
				respuesta.add(cuenta);
				
			}
			
			DBFUtils.close(reader);
			
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
			
		return respuesta;
		
	}
	
	public List<Producto> readProductos(){
		
		List<Producto> respuesta = new ArrayList<Producto>();
		
		reader = null;
		
		try {
			
			reader = new DBFReader(new FileInputStream(Application.DIR_LECTURA + "wbcereal.dbf"));
			
			DBFRow row;
			
			while((row = reader.nextRow()) != null) {
								
				Producto producto = new Producto();
				
				producto.setCodigo(row.getString("cercodigo"));
				
				producto.setDescripcion(row.getString("cernombre").toUpperCase());
				
				respuesta.add(producto);
				
			}
			
			DBFUtils.close(reader);
			
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
			
		return respuesta;
		
	}
	
	
	public List<Puerto> readPuertos(){
		
		List<Puerto> respuesta = new ArrayList<Puerto>();
		
		reader = null;
		
		try {
			
			reader = new DBFReader(new FileInputStream(Application.DIR_LECTURA + "wbpuerto.dbf"));
			
			DBFRow row;
			
			while((row = reader.nextRow()) != null) {
								
				Puerto puerto = new Puerto();
				
				puerto.setCodigo(row.getInt("tblcodigo"));
				
				puerto.setDescripcion(row.getString("tbldescri").toUpperCase());
				
				respuesta.add(puerto);
				
			}
			
			DBFUtils.close(reader);
			
		} catch (FileNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
			
		return respuesta;
		
	}
	
}

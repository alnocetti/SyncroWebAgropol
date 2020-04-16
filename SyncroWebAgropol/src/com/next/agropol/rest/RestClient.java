package com.next.agropol.rest;

import java.io.BufferedReader;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.Writer;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.google.gson.reflect.TypeToken;
import com.next.agropol.main.Application;
import com.next.agropol.model.Analisis;
import com.next.agropol.model.Comprobante;
import com.next.agropol.model.Contrato;
import com.next.agropol.model.Cuenta;
import com.next.agropol.model.CuentaCorriente;
import com.next.agropol.model.Descarga;
import com.next.agropol.model.Producto;
import com.next.agropol.model.Puerto;
import com.next.agropol.model.Usuario;
import com.next.agropol.model.Vencimiento;
import com.next.agropol.reader.Reader;

public class RestClient {
	
	public URL url;//your url i.e fetch data from .
	public HttpURLConnection conn;
	public Reader reader;
	private int intentos;
	
	public RestClient() {
		super();
		this.reader = new Reader();
	}
	
	public void postCuentaCorriente(List<CuentaCorriente> cc) {
		
		intentos = 0;
		
		while (intentos <= 1) {
			
			try {
			
				Gson gson = new GsonBuilder().setPrettyPrinting().create();
				
				Writer writer =  new FileWriter(Application.DIR_ESCRITURA + "CuentasCorrientes.json");
				gson.toJson(cc, writer);
				writer.flush();
				writer.close();
				

			} catch (Exception e) {
				
				System.out.println("Exception in NetClientGet:- " + e);
				intentos++;
				continue;
			}
			
			return;
		}
		
		return;
	}
	
	
	public void postVencimientos(List<Vencimiento> vencimientos) {
		
		intentos = 0;
		
		while (intentos <= 1) {
			
			try {
			
				Gson gson = new GsonBuilder().setPrettyPrinting().create();
				
				Writer writer =  new FileWriter(Application.DIR_ESCRITURA + "Vencimientos.json");
				gson.toJson(vencimientos, writer);
				writer.flush();
				writer.close();
				
			} catch (Exception e) {
				
				System.out.println("Exception in NetClientGet:- " + e);
				intentos++;
				continue;
			}
			
			return;
		}
		
		return;
	}
	
	public void postContratos(List<Contrato> contratos) {
		
		intentos = 0;
		
		while (intentos <= 1) {
			
			try {
			
				Gson gson = new GsonBuilder().setPrettyPrinting().create();
				
				Writer writer =  new FileWriter(Application.DIR_ESCRITURA + "Contratos.json");
				gson.toJson(contratos, writer);
				writer.flush();
				writer.close();

			} catch (Exception e) {
				
				System.out.println("Exception in NetClientGet:- " + e);
				intentos++;
				continue;
			}
			
			return;
		}
		
		return;
	}
	
	public void postDescargas(List<Descarga> descargas) {
		
		intentos = 0;
		
		while (intentos <= 1) {
			
			try {
			
				Gson gson = new GsonBuilder().setPrettyPrinting().create();
				
				Writer writer =  new FileWriter(Application.DIR_ESCRITURA + "Descargas.json");
				gson.toJson(descargas, writer);
				writer.flush();
				writer.close();
				
			} catch (Exception e) {
				
				System.out.println("Exception in NetClientGet:- " + e);
				intentos++;
				continue;
			}
			
			return;
		}
		
		return;
	}

	
	public void postAnalisis(List<Analisis> analisis) {
		
		intentos = 0;
		
		while (intentos <= 1) {
			
			try {
			
				Gson gson = new GsonBuilder().setPrettyPrinting().create();
				
				Writer writer =  new FileWriter(Application.DIR_ESCRITURA + "Analisis.json");
				gson.toJson(analisis, writer);
				writer.flush();
				writer.close();
				
			} catch (Exception e) {
				
				System.out.println("Exception in NetClientGet:- " + e);
				intentos++;
				continue;
			}
			
			return;
		}
		
		return;
	}
	
	public void postComprobantes(List<Comprobante> comprobantes) {
		
		intentos = 0;
		
		while (intentos <= 1) {
			
			try {
			
				Gson gson = new GsonBuilder().setPrettyPrinting().create();
				
				Writer writer =  new FileWriter(Application.DIR_ESCRITURA + "Comprobantes.json");
				gson.toJson(comprobantes, writer);
				writer.flush();
				writer.close();
				
			} catch (Exception e) {
				
				System.out.println("Exception in NetClientGet:- " + e);
				intentos++;
				continue;
			}
			
			return;
		}
		
		return;
	}
	
	public void postCuentas(List<Cuenta> cuentas) {
		
		intentos = 0;
		
		while (intentos <= 1) {
			
			try {
			
				Gson gson = new GsonBuilder().setPrettyPrinting().create();
				
				Writer writer =  new FileWriter(Application.DIR_ESCRITURA + "Cuentas.json");
				gson.toJson(cuentas, writer);
				writer.flush();
				writer.close();
				
			} catch (Exception e) {
				
				System.out.println("Exception in NetClientGet:- " + e);
				intentos++;
				continue;
			}
			
			return;
		}
		
		return;
	}
	
	public void postProductos(List<Producto> productos) {
		
		intentos = 0;
		
		while (intentos <= 1) {
			
			try {
			
				Gson gson = new GsonBuilder().setPrettyPrinting().create();
				
				Writer writer =  new FileWriter(Application.DIR_ESCRITURA + "Productos.json");
				gson.toJson(productos, writer);
				writer.flush();
				writer.close();
				
			} catch (Exception e) {
				
				System.out.println("Exception in NetClientGet:- " + e);
				intentos++;
				continue;
			}
			
			return;
		}
		
		return;
	}
	
	public void postPuertos(List<Puerto> puertos) {
		
		intentos = 0;
		
		while (intentos <= 1) {
			
			try {
			
				Gson gson = new GsonBuilder().setPrettyPrinting().create();
				
				Writer writer =  new FileWriter(Application.DIR_ESCRITURA + "Puertos.json");
				gson.toJson(puertos, writer);
				writer.flush();
				writer.close();
				

			} catch (Exception e) {
				
				System.out.println("Exception in NetClientGet:- " + e);
				intentos++;
				continue;
			}
			
			return;
		}
		
		return;
	}
	
	public void postUsuarios(List<Usuario> usuarios) {
		
		intentos = 0;
		
		while (intentos <= 1) {
			
			try {
			
				Gson gson = new GsonBuilder().setPrettyPrinting().create();
				
				Writer writer =  new FileWriter(Application.DIR_ESCRITURA + "Usuarios.json");
				gson.toJson(usuarios, writer);
				writer.flush();
				writer.close();
				

			} catch (Exception e) {
				
				System.out.println("Exception in NetClientGet:- " + e);
				intentos++;
				continue;
			}
			
			return;
		}
		
		return;
	}
	
	public List<WebResponse> cargaReportes() {
		
		List<WebResponse> webResponses = new ArrayList<WebResponse>();
		
		Gson gson = new GsonBuilder().setPrettyPrinting().create();

		try {
			
			url = new URL("http://localhost:8080/reportes-agropol/wsCargaReportes.php");

			conn = (HttpURLConnection) url.openConnection();
			
			conn.setRequestMethod("GET");
			
			conn.setReadTimeout(30000);
			conn.setConnectTimeout(30000);
			
			//conn.setRequestProperty("Content-Type", "application/json");
			
			conn.setDoOutput(true);
			
			InputStreamReader in = new InputStreamReader(conn.getInputStream());
			
			BufferedReader br = new BufferedReader(in);
			
			String output;
			
			TypeToken<ArrayList<WebResponse>> token = new TypeToken<ArrayList<WebResponse>>() {};
						
			while ((output = br.readLine()) != null) {
								
				webResponses =  gson.fromJson(output,  token.getType());
				
			}
			
//			for (WebResponse wr : webResponses) {
//			
//				JOptionPane.showMessageDialog(null, wr.getMensajeArchivo(), "Syncro web", JOptionPane.INFORMATION_MESSAGE);
//			}
			
			conn.disconnect();
			
		} catch (MalformedURLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		return webResponses;
	}
	
}


package com.next.agropol.main;

import java.io.File;
import java.io.IOException;

import javax.swing.JOptionPane;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;

import org.w3c.dom.Document;
import org.xml.sax.SAXException;

import com.next.agropol.controller.Controller;

public class Application {
	
	public static String DIR_LECTURA;
	public static String DIR_ESCRITURA;

	public static void main(String[] args) throws ParserConfigurationException, SAXException, IOException {
		
		File fXmlFile = new File("Configuration.xml");
		DocumentBuilderFactory dbFactory = DocumentBuilderFactory.newInstance();
		DocumentBuilder dBuilder = dbFactory.newDocumentBuilder();
		Document doc = dBuilder.parse(fXmlFile);

		DIR_LECTURA = doc.getElementsByTagName("DIR_LECTURA").item(0).getTextContent();
		DIR_ESCRITURA = doc.getElementsByTagName("DIR_ESCRITURA").item(0).getTextContent();
		
		System.out.println("Iniciando envio. \n");

		Controller.getInstance().postCuentasCorrientes();
		Controller.getInstance().postVencimientos();
		Controller.getInstance().postContratos();
		Controller.getInstance().postDescargas();
		Controller.getInstance().postAnalisis();
		Controller.getInstance().postComprobantes();
		Controller.getInstance().postCuentas();
		Controller.getInstance().postProductos();
		Controller.getInstance().postPuertos();
		
		String respuesta = Controller.getInstance().cargaReportes();
		
		JOptionPane.showMessageDialog(null, respuesta, "Syncro web", JOptionPane.INFORMATION_MESSAGE);
		
        //JOptionPane.showMessageDialog(null, "Proceso finalizado.", "Syncro web", JOptionPane.INFORMATION_MESSAGE);
        
	}

}

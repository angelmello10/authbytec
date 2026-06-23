import { consume } from "../libclienteweb/consume.js"
import { descargaVista } from "../libclienteweb/descargaVista.js"
import { recibeJson } from "../libclienteweb/recibeJson.js"

descargaDatos()

async function descargaDatos() {
 await descargaVista("api/vista-administrador.php")
 const botonSaludo = document.querySelector("#botonSaludo")
 if (botonSaludo) {
  botonSaludo.addEventListener("click", saludo)
 }
}

async function saludo() {
 const respuesta = await consume(recibeJson('api/saludo-cliente.php'))
 const json = await respuesta.json()
 alert(json)
}

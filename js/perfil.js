import { consume } from "../libclienteweb/consume.js"
import { descargaVista } from "../libclienteweb/descargaVista.js"
import { recibeJson } from "../libclienteweb/recibeJson.js"

descargaDatos()

async function descargaDatos() {
 await descargaVista("api/vista-perfil.php")
 const botonLogout = document.querySelector("#botonLogout")
 if (botonLogout) {
  botonLogout.addEventListener("click", logout)
 }
}

async function logout() {
 await consume(recibeJson('api/logout.php'))
 location.reload()
}
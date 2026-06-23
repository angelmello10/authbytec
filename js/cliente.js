import { consume } from "../libclienteweb/consume.js"
import { descargaVista } from "../libclienteweb/descargaVista.js"
import { recibeJson } from "../libclienteweb/recibeJson.js"
import { submitFormRecibeJson } from "../libclienteweb/submitFormRecibeJson.js"
import { muestraObjeto } from "../libclienteweb/muestraObjeto.js"

/** @type {HTMLFormElement | null} */
const formulario = document.querySelector("form#formulario")
const lista = document.querySelector("#lista")

descargaDatos()

async function descargaDatos() {
 await descargaVista("api/vista-cliente.php")

 if (formulario) {
  formulario.addEventListener("submit", guarda)
 }

 await consulta()
}

/**
 * @param {SubmitEvent} event
 */
async function guarda(event) {
 event.preventDefault()
 if (!formulario) return
 try {
  await consume(submitFormRecibeJson("api/abc-alta.php", formulario))
  formulario.reset()
  await consulta()
 } catch (_error) {
  // manejado por manejaErrores.js
 }
}

async function consulta() {
 try {
  const respuesta = await consume(recibeJson("api/abc-consulta.php"))
  /** @type {any[]} */
  const contactos = await respuesta.json()

  let innerHTML = ""
  for (const c of contactos) {
   innerHTML += /* html */
    `<li>
      <b>${c.CON_NOMBRE}</b> (${c.CON_EMAIL})<br>
      ${c.CON_DESCRIPCION}<br>
      <button type="button" class="eliminar" data-id="${c.CON_ID}">Eliminar</button>
      <br><br>
     </li>`
  }

  if (innerHTML === "") {
   innerHTML = "<li>No hay contactos registrados.</li>"
  }

  muestraObjeto(document, {
   lista: { innerHTML }
  })

  document.querySelectorAll(".eliminar").forEach(boton => {
   if (boton instanceof HTMLButtonElement) {
    boton.addEventListener("click", () => elimina(boton.dataset.id ?? ""))
   }
  })

 } catch (_error) {
  muestraObjeto(document, { lista: { textContent: "Error al cargar contactos." } })
 }
}

/**
 * @param {string} id
 */
async function elimina(id) {
 if (!confirm("¿Estás seguro de eliminar este contacto?")) return
 try {
  const formData = new FormData()
  formData.append("id", id)
  await consume(submitFormRecibeJson("api/abc-baja.php", formData))
  await consulta()
 } catch (_error) {
  // manejado por manejaErrores.js
 }
}
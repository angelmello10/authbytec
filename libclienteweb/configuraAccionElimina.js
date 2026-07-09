import { consume } from "./consume.js"
import { submitFormRecibeJson } from "./submitFormRecibeJson.js"

/**
 * @param {HTMLElement} botonEliminar
 * @param {string} mensaje
 * @param {string} url
 * @param {HTMLFormElement} formulario
 * @param {string} nuevaVista
 */
export async function configuraAccionElimina(
 botonEliminar, mensaje, url, formulario, nuevaVista
) {
 botonEliminar.addEventListener(
  "click",
  async () => {
   if (confirm(mensaje)) {
    await consume(submitFormRecibeJson(url, formulario))
    location.href = nuevaVista
   }
  }
 )
}
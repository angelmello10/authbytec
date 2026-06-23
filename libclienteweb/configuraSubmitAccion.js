import { consume } from "./consume.js"
import { submitFormRecibeJson } from "./submitFormRecibeJson.js"

/**
 * @param {string} url
 * @param {HTMLFormElement} formulario
 * @param {string} nuevaVista
 */
export function configuraSubmitAccion(url, formulario, nuevaVista) {
 formulario.addEventListener(
  "submit",
  async event => {
   event.preventDefault()
   await consume(submitFormRecibeJson(url, formulario))
   location.href = nuevaVista
  }
 )
}
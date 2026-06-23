/**
 * Envía los datos de un formolario a la url usando la codificación
 * multipart/form-data.
 * @param {string} url
 * @param {HTMLFormElement | FormData} formulario
 * @param { "GET" | "POST"| "PUT" | "PATCH" | "DELETE" | "TRACE" | "OPTIONS"
 *  | "CONNECT" | "HEAD" } metodoHttp
 */
export function submitFormRecibeJson(url, formulario, metodoHttp = "POST") {

 const formData =
  formulario instanceof FormData ? formulario : new FormData(formulario)

 if (tieneArchivos(formData)) {

  return fetch(
   url,
   {
    method: metodoHttp,
    headers: { "Accept": "application/json, application/problem+json" },
    body: formData
   }
  )

 } else {

  // @ts-ignore
  const params = new URLSearchParams(formData)
  const queryString = params.toString()

  return fetch(
   url,
   {
    method: metodoHttp,
    headers: {
     'Content-Type': 'application/x-www-form-urlencoded',
     "Accept": "application/json, application/problem+json"
    },
    body: queryString
   }
  )

 }

}

/**
 * @param {FormData} formData
 */
function tieneArchivos(formData) {
 for (const value of formData.values()) {
  if (value instanceof File) {
   return true
  }
 }
 return false
}
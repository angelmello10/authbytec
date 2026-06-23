export class MiNav extends HTMLElement {

 constructor() {
  super()
  this.cargado = false
 }

 connectedCallback() {

  this.style.display = "block"

  if (this.cargado === false) {
   this.innerHTML = /* html */
    `<style>
      mi-nav nav {
        background-color: #ffffff;
        padding: 12px 20px;
        border-radius: 6px;
        border: 1px solid #e0e0e0;
      }
      mi-nav ul {
        list-style: none;
        display: flex;
        gap: 20px;
        align-items: center;
      }
      mi-nav li {
        font-size: 0.95rem;
      }
      mi-nav a {
        color: #666666;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
      }
      mi-nav a:hover {
        color: #333333;
      }
      mi-nav progress {
        width: 80px;
        height: 6px;
        accent-color: #666666;
      }
      mi-nav #aPerfil {
        margin-left: auto;
      }
      mi-nav #san {
        color: #333333;
        font-weight: 600;
      }
    </style>
    <nav>
      <ul>
       <li><a href="index.html">Inicio</a></li>
       <li id="ocupado"><progress max="100">Cargando&hellip;</progress></li>
       <li id="aAdmin" hidden>
        <a href="administrador.html">Para administradores</a>
       </li>
       <li id="aCliente" hidden><a href="cliente.html">Para clientes</a></li>
       <li id="san" hidden></li>
       <li id="aPerfil"><a href="perfil.html">Perfil</a></li>
      </ul>
     </nav>`

   this.cargado = true
  }
 }

}

customElements.define("mi-nav", MiNav)
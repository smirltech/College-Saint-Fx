import './bootstrap';
import Alpine from 'alpinejs'
import Swal from 'sweetalert2';
import printJS from 'print-js';
import {Modal} from 'bootstrap';
import ApexCharts from 'apexcharts';


import('@popperjs/core');
import('bootstrap');


window.Alpine = Alpine;
window.Swal = Swal;
window.PrintJS = printJS;
window.ApexCharts = ApexCharts;


window.Modal = Modal;


Alpine.start();


window.addEventListener('closeModal', event => {
    //alert(event.detail.modal);
    //event.detail.modal.style.display = "none"
    //   var modal = document.getElementById(event.detail.modal);
    //   modal.hide();
    console.log(event.detail.modal);

    const modal = document.getElementById(event.detail.modal);

    // change state like in hidden modal
    modal.classList.remove('show');
    modal.setAttribute('aria-hidden', 'true');
    modal.setAttribute('style', 'display: none');

    // get modal backdrop
    const modalBackdrops = document.getElementsByClassName('modal-backdrop');

    // remove opened modal backdrop
    document.body.removeChild(modalBackdrops[0]);

});


window.addEventListener('printIt', event => {
    console.log(event.detail.elementId);
    printJS({
        printable: event.detail.elementId,
        type: event.detail.type,
        targetStyles: ['*'],
        maxWidth: event.detail.maxWidth,
        style: "text-align:center"
    });
})








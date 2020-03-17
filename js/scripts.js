feather.replace();
/* QR Code */
var site_qr = document.getElementById("site-qr");
var url = site_qr.dataset.url;
var qr = new VanillaQR({
  url: url,
  size: 200,
  toTable: true
});
site_qr.appendChild(qr.domElement);

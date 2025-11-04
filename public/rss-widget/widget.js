(function () {
  const containerId =
    document.currentScript.getAttribute("data-container") || "rss-widget";
  const limit =
    parseInt(document.currentScript.getAttribute("data-limit")) || 5;
  const title =
    document.currentScript.getAttribute("data-title") ||
    "Berita Terbaru - Humas Sinjai";
  const theme = document.currentScript.getAttribute("data-theme") || "light";
  const apiUrl = "https://humas.sinjaikab.go.id/v1/rss-widget/index.php";

  fetch(apiUrl)
    .then((res) => res.json())
    .then((data) => {
      const el = document.getElementById(containerId);
      if (!el) return;

      if (data.error) {
        el.innerHTML = `<p>${data.error}</p>`;
        return;
      }

      // struktur widget
      let html = `
        <div class="humas-sinjai-widget humas-sinjai-${theme}">
          <h4 class="humas-sinjai-title">${title}</h4>
          <ul>
      `;

      // daftar berita
      data.slice(0, limit).forEach((item) => {
        html += `
          <li class="humas-sinjai-item">
            ${
              item.thumbnail
                ? `
              <div class="humas-sinjai-thumb-wrapper">
                <img src="${item.thumbnail}" alt="${item.title}" class="humas-sinjai-thumb">
              </div>`
                : ""
            }
            <div class="humas-sinjai-content">
              <a href="${item.link}" target="_blank">${item.title}</a>
              <small>${item.pubDate}</small>
            </div>
          </li>
        `;
      });

      // footer widget
      html += `
          </ul>
          <div class="humas-sinjai-footer">
            <a href="https://humas.sinjaikab.go.id" target="_blank">humas.sinjaikab.go.id</a>
          </div>
        </div>
      `;

      el.innerHTML = html;
    })
    .catch(() => {
      const el = document.getElementById(containerId);
      if (el) el.innerHTML = "<p>Gagal memuat berita.</p>";
    });
})();

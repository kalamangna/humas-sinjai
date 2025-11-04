(function () {
  const containerId =
    document.currentScript.getAttribute("data-container") || "rss-widget";
  const limit =
    parseInt(document.currentScript.getAttribute("data-limit")) || 5;
  const title =
    document.currentScript.getAttribute("data-title") ||
    "Latest News from Humas Sinjai";
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

      let html = `<div class="rss-widget ${theme}"><h4 class="rss-title">${title}</h4><ul>`;
      data.slice(0, limit).forEach((item) => {
        html += `<li><a href="${item.link}" target="_blank">${item.title}</a><br><small>${item.pubDate}</small></li>`;
      });
      html += `</ul><div class="rss-footer"><a href="https://humas.sinjaikab.go.id" target="_blank">humas.sinjaikab.go.id</a></div></div>`;
      el.innerHTML = html;
    })
    .catch(() => {
      document.getElementById(containerId).innerHTML =
        "<p>Failed to load news.</p>";
    });
})();

document.addEventListener("DOMContentLoaded", function (event) {
  const loopImportBtn = document.getElementById("loop-events-json-import");
  const loopExportBtn = document.getElementById("loop-events-json-export");
  const nonce = document.getElementById("_wpnonce");
  if (!loopImportBtn) {
    return;
  }

  loopImportBtn.addEventListener("click", function (e) {
    // Prepare request.
    const jsonData = document.getElementById("loop-events-json").files[0];
    if (!jsonData) {
      alert("No file selected");
      return;
    }

    // Disable button to prevent multiple clicks.
    e.target.setAttribute("disabled", "disabled");

    // Show loading icon.
    const spinner = showLoader();
    e.target.insertAdjacentElement("afterend", spinner);

    const formData = new FormData();
    formData.append("action", "loop_events_settings");
    formData.append("nonce", nonce.value);
    formData.append("events", jsonData);

    // Send request and handle response.
    fetch(ajaxurl, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((res) => {
        const existingResults = document.querySelector(".loop-events-badge");
        if (existingResults) {
          existingResults.parentElement.removeChild(existingResults);
        }
        // Remove loading icon.
        e.target.parentNode.removeChild(spinner);
        // Re-enable button.
        e.target.removeAttribute("disabled");
        // Show results.
        const badge = showResults(res.success, res.data.message);
        e.target.insertAdjacentElement("afterend", badge);
      });
  });

  loopExportBtn.addEventListener("click", function (e) {
    // Disable button to prevent multiple clicks.
    e.target.setAttribute("disabled", "disabled");

    // Show loading icon.
    const spinner = showLoader();
    e.target.insertAdjacentElement("afterend", spinner);

    const formData = new FormData();
    formData.append("action", "loop_events_export");
    formData.append("nonce", nonce.value);

    // Send request and handle response.
    fetch(ajaxurl, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((res) => {
        const existingResults = document.querySelector(".loop-events-badge");
        if (existingResults) {
          existingResults.parentElement.removeChild(existingResults);
        }
        // Remove loading icon.
        e.target.parentNode.removeChild(spinner);
        // Re-enable button.
        e.target.removeAttribute("disabled");

        const blob = new Blob([res]);
        const link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = "loop-events.json";
        link.click();
      });
  });

  // Shows loading icon.
  function showLoader() {
    const loader = document.createElement("div");
    loader.className = "loop-events-loader";
    return loader;
  }

  // Shows result as a badge and message.
  function showResults(status, text) {
    const badge = document.createElement("div");
    badge.className = status
      ? "loop-events-badge loop-events-badge-success"
      : "loop-events-badge loop-events-badge-error";
    badge.textContent = text;
    return badge;
  }
});

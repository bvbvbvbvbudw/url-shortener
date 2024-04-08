const form = document.querySelector(".wrapper form"),
    fullURL = form.querySelector("input"),
    shortenBtn = form.querySelector("button"),
    blurEffect = document.querySelector(".blur-effect"),
    popupBox = document.querySelector(".popup-box"),
    infoBox = popupBox.querySelector(".info-box"),
    form2 = popupBox.querySelector("form"),
    shortenURL = popupBox.querySelector(".shorten-url"),
    copyIcon = popupBox.querySelector(".copy-icon"),
    saveBtn = popupBox.querySelector("button");

form.addEventListener('submit', (e) => {
    e.preventDefault();
});

shortenBtn.addEventListener('click', () => {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "php/url-controll.php", true);
    xhr.onload = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            const data = xhr.response;
            if (data.length <= 5) {
                blurEffect.style.display = "block";
                popupBox.classList.add("show");

                const domain = window.location.origin + '/';
                shortenURL.value = domain + data;

                copyIcon.addEventListener('click', () => {
                    shortenURL.select();
                    document.execCommand("copy");
                });

                saveBtn.addEventListener('click', () => {
                    form2.addEventListener('submit', (e) => {
                        e.preventDefault();
                    });

                    const xhr2 = new XMLHttpRequest();
                    xhr2.open("POST", "php/save-url.php", true);
                    xhr2.onload = () => {
                        if (xhr2.readyState == 4 && xhr2.status == 200) {
                            const responseData = xhr2.response;
                            if (responseData == "success") {
                                location.reload();
                            } else {
                                infoBox.classList.add("error");
                                infoBox.innerText = responseData;
                            }
                        }
                    };

                    const shorten_url1 = shortenURL.value;
                    const hidden_url = data;
                    xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr2.send("shorten_url=" + shorten_url1 + "&hidden_url=" + hidden_url);
                });
            } else {
                alert(data);
            }
        }
    };

    const formData = new FormData(form);
    xhr.send(formData);
});

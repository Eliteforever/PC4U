function createToast(toastText, toastDest, toastBackground) {
    Toastify({
        text: toastText,
        duration: 3000,
        destination: toastDest,
        newWindow: true,
        close: true,
        gravity: "bottom", // `top` or `bottom`
        positionLeft: true, // `true` or `false`
        backgroundColor: "#" + toastBackground
    }).showToast();
}
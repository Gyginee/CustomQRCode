const imgsrc = document.getElementById("qrimage");
const imageBlobs = [];

function getValueWithoutHash(color) {
    return color.slice(1); // Removes the first character, which is "#"
}

function wait(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function updateQRCode() {
    const marginValue = marginInput.value;
    const sizeValue = sizeInput.value;
    const formatValue = formatSelect.value;
    const mainColorValue = getValueWithoutHash(mainColorInput.value);
    const foreColorValue = getValueWithoutHash(foreColorInput.value);
    const errorCorrectionValue = errorCorrectionSelect.value;
    const logoValue = logoInput.value;
    const ratioValue = ratioInput.value;
    const logoWidthValue = logoWidthInput.value;
    const logoHeightValue = logoHeightInput.value;


    const qrCodeUrl = `https://quickchart.io/qr?text=QRSAMPLE&margin=${marginValue}&size=${sizeValue}&format=${formatValue}&dark=${mainColorValue}&light=${foreColorValue}&ecLevel=${errorCorrectionValue}&centerImageUrl=${logoValue}&centerImageSizeRatio=${ratioValue}&centerImageWidth=${logoWidthValue}&centerImageHeight=${logoHeightValue}`;

    imgsrc.src = qrCodeUrl;
}

function ExportSubmit(event) {
    event.preventDefault();
    const csvFile = document.getElementById("csvFile").files[0];
    const formData = new FormData();
    formData.append("csvFile", csvFile);

    fetch("/process_csv.php", {
            method: "POST",
            body: formData,
        })
        .then((response) => response.json())
        .then((qrData) => {
            qrData.forEach((row) => {
                const name = row.name;
                const content = row.content;
                const link = row.link;
                getContentQR(name, content, link);
            });

            wait(5000).then(() => {
                const zip = new JSZip();
                imageBlobs.forEach((imageBlob) => {
                    zip.file(imageBlob.name, imageBlob.blob);
                });

                zip.generateAsync({
                    type: "blob"
                }).then(function(content) {
                    saveAs(content, "images.zip");
                });
            });
        })
        .catch((error) => {
            console.error("Error processing CSV file:", error);
        });
}

async function downloadImage(imageName, imageSrc) {
    const image = await fetch(imageSrc);
    const imageBlob = await image.blob();
    const imageNameWithExtension = imageName.endsWith("." + formatSelect.value) ? imageName : imageName + "." + formatSelect.value;

    return {
        name: imageNameWithExtension,
        blob: imageBlob
    };
}

async function getContentQR(name, content, link) {
    const marginValue = marginInput.value;
    const sizeValue = sizeInput.value;
    const formatValue = formatSelect.value;
    const mainColorValue = getValueWithoutHash(mainColorInput.value);
    const foreColorValue = getValueWithoutHash(foreColorInput.value);
    const errorCorrectionValue = errorCorrectionSelect.value;
    const logoValue = logoInput.value;
    const ratioValue = ratioInput.value;
    const logoWidthValue = logoWidthInput.value;
    const logoHeightValue = logoHeightInput.value;

    const qrCodeUrl = `https://quickchart.io/qr?text=${content}&margin=${marginValue}&size=${sizeValue}&format=${formatValue}&dark=${mainColorValue}&light=${foreColorValue}&ecLevel=${errorCorrectionValue}&centerImageUrl=${link}&centerImageSizeRatio=${ratioValue}&centerImageWidth=${logoWidthValue}&centerImageHeight=${logoHeightValue}`;

    try {
        const response = await fetch(qrCodeUrl);
        if (!response.ok) {
            throw new Error("Network response was not ok.");
        }
        const qrContent = await response.text();
        imgsrc.src = qrCodeUrl;
        const imageBlob = await downloadImage(name, qrCodeUrl);
        imageBlobs.push(imageBlob);
    } catch (error) {
        console.error("Error fetching QR content:", error);
    }
}

function changeWHLogo(event) {
    event.preventDefault();

    const sizeValue = parseInt(document.getElementById("size").value);
    const configSize = Math.floor(sizeValue / 3);

    const logoWidthInput = document.getElementById("logoWidth");
    const logoHeightInput = document.getElementById("logoHeight");

    logoWidthInput.value = configSize;
    logoHeightInput.value = configSize;
}

const marginInput = document.getElementById("margin");
const sizeInput = document.getElementById("size");
const formatSelect = document.getElementById("format");
const mainColorInput = document.getElementById("mainColor");
const foreColorInput = document.getElementById("foreColor");
const errorCorrectionSelect = document.getElementById("errorCorrection");
const logoInput = document.getElementById("logo");
const ratioInput = document.getElementById("ratio");
const logoWidthInput = document.getElementById("logoWidth");
const logoHeightInput = document.getElementById("logoHeight");

sizeInput.addEventListener("change", changeWHLogo);

updateQRCode();

const configForm = document.getElementById("configForm");
configForm.addEventListener("change", updateQRCode);

const exportForm = document.getElementById("export");
exportForm.addEventListener("submit", ExportSubmit);
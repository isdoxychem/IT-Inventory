function removeVowels(str) {
    // Use a regular expression to replace vowels (both upper and lower case) with an empty string
    return str.replace(/[aeiouEI]/g, '');
}
function displaySelectedValue() {
    // Get the select element
    const selectElement = document.getElementById("Type");

    // Get the selected value
    var selectedValue = selectElement.options[selectElement.selectedIndex].value;

    var asset = removeVowels(selectedValue);
    var assetTag = asset.toUpperCase();

    // Display the selected value in the output display
    document.getElementById("tag").innerText = assetTag;
    

    // const serial = document.getElementById("serial");
    // const mobile = document.getElementById("mobile");
    // const model = document.getElementById("model");
    // const processor = document.getElementById("processor");
    // const plan = document.getElementById("plan");
    // const ram = document.getElementById("ram");
    // const storage = document.getElementById("storage");
    // const os = document.getElementById("os");
    // const dimes = document.getElementById("dimes");

    // if(selectElement.value == "SIM") {
    //     serial.style.display = "none";
    //     model.style.display = "none";
    //     processor.style.display = "none";
    //     ram.style.display = "none";
    //     storage.style.display = "none";
    //     os.style.display = "none";
    //     dimes.style.display = "none";

    //     mobile.style.display = "block";
    //     plan.style.display = "block";
    // } else if(selectElement.value == "Laptop" || selectElement.value == "Desktop") {
    //     serial.style.display = "block";
    //     model.style.display = "block";
    //     processor.style.display = "block";
    //     ram.style.display = "block";
    //     storage.style.display = "block";
    //     os.style.display = "block";

    //     dimes.style.display = "none";
    //     mobile.style.display = "none";
    //     plan.style.display = "none";
    // } else if(selectElement.value == "Monitor" || selectElement.value == "UPS" || selectElement.value == "AVR" || selectElement.value == "Printer") {
    //     processor.style.display = "none";
    //     ram.style.display = "none";
    //     storage.style.display = "none";
    //     os.style.display = "none";
    //     mobile.style.display = "none";
    //     plan.style.display = "none";

    //     serial.style.display = "block";
    //     model.style.display = "block";
    //     dimes.style.display = "block";
    // } else if(selectElement.value == "Mobile") {
    //     processor.style.display = "none";
    //     dimes.style.display = "none";
    //     os.style.display = "none";
    //     mobile.style.display = "none";
    //     plan.style.display = "none";

    //     serial.style.display = "block";
    //     model.style.display = "block";
    //     ram.style.display = "block";
    //     storage.style.display = "block";
    // } else {
    //     processor.style.display = "none";
    //     ram.style.display = "none";
    //     storage.style.display = "none";
    //     os.style.display = "none";
    //     mobile.style.display = "none";
    //     plan.style.display = "none";

    //     serial.style.display = "block";
    //     model.style.display = "block";
    //     dimes.style.display = "none";
    // }
    
}

function changetextbox() {
    var status = document.getElementById("status");
    var repair = document.getElementById("repair-cost");
    var datedeployed = document.getElementById("datedeployed");
    var assignto = document.getElementById("assignedto");
    
    if (status.value == "For repair") {
        repair.style.display = "block";
        datedeployed.style.display = "none";
        assignto.style.display = "none";
    } else if (status.value == "Deployed") {
        datedeployed.style.display = "block";
        repair.style.display = "none";
        assignto.style.display = "block";
    } else {
        repair.style.display = "none";
        datedeployed.style.display = "none";
        assignto.style.display = "none";
    }
}

function passValue() {
    var divValue = document.getElementById("tag").innerText;

    // Set the value of the input field
    document.getElementById("asset-tag").value = divValue;
}

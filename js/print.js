let print = document.querySelector("#print");
let back = document.querySelector("#back");
print.addEventListener("click", function() {
    window.print();
});

back.addEventListener("click", function() {
    window.location="../admin/dashboard.php";
});
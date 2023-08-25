const scholarshipsBtns = document.querySelectorAll('.scholarships-buttons');
const scholarshipBtn = document.querySelector('#scholarship-tab');
const scholarshipBtnBS = new bootstrap.Tab(scholarshipBtn);
const registerTabBtn = document.querySelector('#register-tab');
const registerTabBtnBS = new bootstrap.Tab(registerTabBtn);

const scholarshipRegisterData = [];

// Cek IPK
function checkGPA() {
    const isGPAPass = !(Number(document.querySelector('#ipk-field').value) >= 3.0) 
    document.querySelector('#beasiswa-field').disabled = isGPAPass;
    document.querySelector('#upload').disabled = isGPAPass;
    document.querySelector('#daftar').disabled = isGPAPass;
}

function storeData(form, callback) {
    let http = new XMLHttpRequest();

    http.onreadystatechange = function () {
        if (this.readyState == 4) {
            callback(JSON.parse(this.responseText));
        }
    };

    http.open("POST", "submit.php", true);
    http.send(new FormData(form));
}


// Scholarship Type Trigger
scholarshipsBtns.forEach(el => {
    el.addEventListener('click', () => {
        registerTabBtnBS.show()
    })
});

/**
 * Auto generate GPA (IPK) Trigger
 * 
 * Math.random() : Generate number dari 0.0 hingga 1.0 
 * toFixed(n) : membulatkan bilangan sebanyak n digit dibelakang koma
 */
const semesterSelect = document.querySelector('#semester-field');
semesterSelect.addEventListener('change', () => {
    document.querySelector('#ipk-field').value = ((Math.random() * 3) + 1.0).toFixed(1);
    checkGPA();
});

// Cancel Button Trigger
const cancelBtn = document.querySelector('#cancel');

cancelBtn.addEventListener('click', () => {
    document.querySelector('#register-form').reset();
    scholarshipBtnBS.show();
});

// Register Button Trigger
const registerBtn = document.querySelector('#daftar');

function handleResponse(obj) {
    if (obj.status === 200) {
        alert("Sukses Coy!");
        document.querySelector('#register-form').reset();
    }
    else {
        alert(obj.msg);
    }
}

registerBtn.addEventListener('click', (e) => {
    storeData(document.getElementById("register-form"), handleResponse);
    e.preventDefault();
});

/*
 * Taken from: https://stackoverflow.com/a/6234804/7275114
 */
function escapeHtml(unsafe)
{
    return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
}

function translateStatus(p)
{
    switch (p) {
        case "Verified":
            return "Sudah di Verifikasi";
        case "Pending":
            return "Belum diverifikasi";
        default:
            return "Unknown";
    }
}

function doFill(data)
{
    const tableData = document.getElementById('table-result');
    let i;
    let r = "";
    for(i of data){
        r += "<tr>"+
            "<td>"+escapeHtml(i.id)+"</td>" +
            "<td>"+escapeHtml(i.name)+"</td>" +
            "<td>"+escapeHtml(i.email)+"</td>" +
            "<td>"+escapeHtml(i.phone)+"</td>" +
            "<td>"+escapeHtml(i.semester)+"</td>" +
            "<td>"+escapeHtml(i.gpa)+"</td>" +
            "<td>"+escapeHtml(i.type)+"</td>" +
            `<td><a target="_blank" href="upload/${escapeHtml(i.file)}">${escapeHtml(i.file)}</a></td>` +
            "<td>"+escapeHtml(translateStatus(i.status))+"</td>" +
        "</tr>";
    }
    tableData.innerHTML = r;
}

const tableData = document.querySelector("#table-data");
const tableLoading = document.getElementById("table-loading");

function stopLoading()
{
    tableData.classList.remove('d-none');
    tableLoading.classList.add('d-none');
}

function startLoading()
{
    tableLoading.classList.remove('d-none');
}

function fillTableData()
{
    startLoading();
    fetch("show.php").then(res => {
        return res.json()
    }).then(data => {
        doFill(data);
    }).catch(e => {
        alert("An error occured");
        console.log(e);
    }).finally(() => {
        stopLoading();
    })
}

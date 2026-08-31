const modalBeli = document.getElementById("modalBeli");
const modalTitle = modalBeli.querySelector(".modal-title");
const namaModal = modalBeli.querySelector(".modal-body #nama");
const hargaModal = modalBeli.querySelector(".modal-body #harga");
const stockModal = modalBeli.querySelector(".modal-body #stock");
const quantity = modalBeli.querySelector("#quantity");
const fotoModal = modalBeli.querySelector(".modal-body #foto");
const deskripsiModal = modalBeli.querySelector(".modal-body #deskripsi");
const table = document.getElementById("keranjang");

if (modalBeli) {
    modalBeli.addEventListener("show.bs.modal", (event) => {
        // Button that triggered the modal
        const button = event.relatedTarget;

        // Extract info from data-* attributes
        const nama = button.getAttribute("data-nama");
        const harga = button.getAttribute("data-harga");
        const stock = button.getAttribute("data-stock");
        const id = button.getAttribute("data-id");
        const foto = button.getAttribute("data-foto");
        const detail = button.getAttribute("data-detail");

        modalTitle.textContent = `Beli Barang - ${nama}`;
        namaModal.textContent = nama;
        hargaModal.textContent = harga;
        stockModal.textContent = stock;
        modalBeli.setAttribute("data-id", id);
        quantity.min = 0;
        quantity.max = stock;
        if(foto.length === 0) {
            fotoModal.src = 'https://source.unsplash.com/random/'+getRandomInt(1, 100);
            // console.log(foto);

        }
        else {
            fotoModal.src = 'uploads/'+foto;
        }
        deskripsiModal.textContent = detail;

        // Check if the selected item is already in the table
        const rows = table.querySelectorAll("tbody tr");
        const selectedId = modalBeli.getAttribute("data-id");
        let existingQuantity = 1;

        rows.forEach((row) => {
            const rowId = row.getAttribute("data-id");
            if (rowId === selectedId) {
                const quantityCell = row.querySelector("td:nth-child(3)");
                existingQuantity = parseInt(quantityCell.textContent);
            }
        });

        quantity.value = existingQuantity;
    });
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}


// Load cart data from local storage
window.addEventListener("load", () => {
    const cartData = localStorage.getItem("cart");
    if (cartData) {
        const cart = JSON.parse(cartData);
        const tbody = table.querySelector("tbody");
        tbody.innerHTML = "";

        cart.forEach((item) => {
            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td></td>
                <td>${item.nama}</td>
                <td>${item.quantity}</td>
                <td>Rp ${formatRupiah(item.harga)}</td>
                <td>Rp ${formatRupiah(item.quantity * item.harga)}</td>
                <td>
                    <button class="btn btn-danger" onclick="removeFromCart(this)">Remove</button>
                </td>
            `;
            newRow.setAttribute("data-id", item.id);
            tbody.appendChild(newRow);
        });

        // renumber the table
        const rows = tbody.children;
        if (rows.length > 0) {
            for (let i = 0; i < rows.length; i++) {
                rows[i].children[0].textContent = i + 1;
            }
        } else {
            tbody.innerHTML = `
                <tr id="placeholder">
                    <td colspan="6" class="text-center">List keranjang masih kosong</td>
                </tr>`;
        }
    }
});

function addToCart() {
    // get the id, name, price, and the quantity
    const id = modalBeli.getAttribute("data-id");
    const namaModal = modalBeli.querySelector(".modal-body #nama").textContent;
    const hargaModal =
        modalBeli.querySelector(".modal-body #harga").textContent;
    let quantity = modalBeli.querySelector("#quantity").value;

    // cek apakah quantity valid atau tidak
    const stock = modalBeli.querySelector("#stock").textContent;
    if (quantity > stock) {
        quantity = stock;
    }
    if (quantity < 0) {
        quantity = 0;
    }

    // create an object for the item
    const item = {
        id: id,
        nama: namaModal,
        harga: hargaModal,
        quantity: quantity,
    };

    // get the existing cart data from local storage
    const cartData = localStorage.getItem("cart");
    let cart = [];

    if (cartData) {
        cart = JSON.parse(cartData);
    }

    // check if the quantity is 0
    if (quantity == 0) {
        // remove the item from the cart if it exists
        const existingItemIndex = cart.findIndex((item) => item.id === id);
        if (existingItemIndex !== -1) {
            cart.splice(existingItemIndex, 1);
            // remove the row from the table
            const tbody = table.querySelector("tbody");
            const row = tbody.querySelector(`tr[data-id="${id}"]`);
            row.remove();
            // check if the table is empty
            if (tbody.children.length === 0) {
                const newRow = document.createElement("tr");
                newRow.innerHTML = `
                    <td colspan="6" class="text-center"">List keranjang masih kosong</td>`;
                newRow.setAttribute("id", "placeholder");
                tbody.appendChild(newRow);
            } else {
                // renumber the table
                const rows = tbody.children;
                for (let i = 0; i < rows.length; i++) {
                    rows[i].children[0].textContent = i + 1;
                }
            }
        }
    } else {
        // check if the item is already in the cart
        const existingItemIndex = cart.findIndex((item) => item.id === id);

        if (existingItemIndex !== -1) {
            // update the quantity of the existing item
            cart[existingItemIndex].quantity = quantity;
            // update the row in the table
            const tbody = table.querySelector("tbody");
            const row = tbody.querySelector(`tr[data-id="${id}"]`);
            row.querySelector("td:nth-child(3)").textContent = quantity;
            row.querySelector(
                "td:nth-child(5)"
            ).textContent = `Rp ${formatRupiah(quantity * hargaModal)}`;
        } else {
            // add the item to the cart
            cart.push(item);
            // remove placeholder if exist
            const placeholder = document.getElementById("placeholder");
            if (placeholder) {
                placeholder.remove();
            }
            // append the new row to the table
            const tbody = table.querySelector("tbody");
            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td>${tbody.children.length + 1}</td>
                <td>${namaModal}</td>
                <td>${quantity}</td>
                <td>Rp ${formatRupiah(hargaModal)}</td>
                <td>Rp ${formatRupiah(quantity * hargaModal)}</td>
                <td>
                <button class="btn btn-danger" onclick="removeFromCart(this)">Remove</button>
                </td>
            `;
            newRow.setAttribute("data-id", id);
            tbody.appendChild(newRow);
        }
    }

    // save the updated cart data to local storage
    localStorage.setItem("cart", JSON.stringify(cart));
}

function removeFromCart(button) {
    const row = button.closest("tr");
    const id = row.getAttribute("data-id");

    // remove the item from the cart data in local storage
    const cartData = localStorage.getItem("cart");
    if (cartData) {
        const cart = JSON.parse(cartData);
        const updatedCart = cart.filter((item) => item.id !== id);
        localStorage.setItem("cart", JSON.stringify(updatedCart));
    }

    row.remove();

    // check if the table is empty
    const tbody = table.querySelector("tbody");
    if (tbody.children.length === 0) {
        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td colspan="6" class="text-center">List keranjang masih kosong</td>`;
        newRow.setAttribute("id", "placeholder");
        tbody.appendChild(newRow);
    } else {
        // renumber the table
        const rows = tbody.children;
        for (let i = 0; i < rows.length; i++) {
            rows[i].children[0].textContent = i + 1;
        }
    }
}

function formatRupiah(angka) {
    var number_string = angka.toString().replace(/[^,\d]/g, ""),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return rupiah;
}

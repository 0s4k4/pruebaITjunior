let create = document.querySelector("#create");
let modal = document.querySelector("#create-user");
let update_model = document.querySelector("#update-user");
let close = document.querySelector("#close")
let update_close = document.querySelector("#update_close")
let save = document.querySelector("#save");
let update = document.querySelector("#update");
let success = document.querySelector(".alert-success")
let error = document.querySelector(".alert-danger")

let userIdToDelete; // Variable para almacenar el ID del usuario a eliminar




function openDeleteModal(id) {
    userIdToDelete = id; // Almacena el ID del usuario a eliminar
    document.querySelector("#confirm-delete-modal").style.display = "block"; // Muestra el modal
}


create.addEventListener("click", () => {
    modal.style.display = "flex";
});
close.addEventListener("click", () => {
    modal.style.display = "none";
})
update_close.addEventListener("click", () => {
    update_model.style.display = "none";

})


// create user

save.addEventListener("click", async () => {
    // Limpiar mensajes de error
    document.querySelector("#name-error").style.display = "none";
    document.querySelector("#age-error").style.display = "none";
    document.querySelector("#country-error").style.display = "none";

    let isValid = true;

    // Validar nombre
    const name = document.querySelector("#name").value.trim();
    if (!name) {
        document.querySelector("#name-error").style.display = "block";
        isValid = false;
    }

    // Validar edad
    const age = document.querySelector("#age").value;
    if (!age || age <= 0) {
        document.querySelector("#age-error").style.display = "block";
        isValid = false;
    }

    // Validar país
    const country = document.querySelector("#country").value.trim();
    if (!country) {
        document.querySelector("#country-error").style.display = "block";
        isValid = false;
    }

    // Si los datos no son válidos, detener el envío
    if (!isValid) {
        return;
    }

    // Si los datos son válidos, continuar con la solicitud
    try {
        const res = await fetch("php/insert-data.php", {
            method: "POST",
            body: JSON.stringify({ "name": name, "age": age, "country": country }),
            headers: {
                "Content-Type": "application/json"
            }
        });
        const output = await res.json();

        if (output.success) {
            success.style.display = "flex";
            success.innerText = output.message;
            document.querySelector("#name").value = "";
            document.querySelector("#age").value = "";
            document.querySelector("#country").value = "";
            modal.style.display = "none";
            getUsers();
            getTotalCount();
            setTimeout(() => {
                success.style.display = "none";
                success.innerText = "";
            }, 1000);
        } else {
            error.style.display = "flex";
            error.innerText = output.message;
            setTimeout(() => {
                error.style.display = "none";
                error.innerText = "";
            }, 1000);
        }
    } catch (error) {
        error.style.display = "flex";
        error.innerText = error.message;
        setTimeout(() => {
            error.style.display = "none";
            error.innerText = "";
        }, 1000);
    }
});

// select user

const getUsers = async () => {
    try {
        const tbody = document.querySelector("#tbody");
        let tr = "";
        const res = await fetch("php/select-data.php", {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        });

        const output = await res.json();
        if (output.empty === "empty") {
            tr = "<tr>Record Not Found</td>"
        } else {
            for (var i in output) {
                tr += `
            <tr>
            <td>${parseInt(i) + 1}</td>
            <td>${output[i].user_name}</td>
            <td>${output[i].user_age}</td>
            <td>${output[i].user_country}</td>
            <td><button onclick="editUser(${output[i].id})" class="btn btn-success">EDITAR</button></td>
            <td><button onclick="openDeleteModal(${output[i].id})" class="btn btn-danger">ELIMINAR</button></td>
            </tr>`
            }
        }
        tbody.innerHTML = tr;
    } catch (error) {
        console.log("error " + error)
    }
}

getUsers();


// edit users

const editUser = async (id) => {
    update_model.style.display = "flex";

    const res = await fetch(`php/edit-data.php?id=${id}`, {
        method: "GET",
        headers: { 'Content-Type': 'application/json' }
    })
    const output = await res.json();
    if (output["empty"] !== "empty") {
        for (var i in output) {
            document.querySelector("#id").value = output[i].id
            document.querySelector("#edit_name").value = output[i].user_name
            document.querySelector("#edit_age").value = output[i].user_age
            document.querySelector("#edit_country").value = output[i].user_country
        }
    }

}

// update user

update.addEventListener("click", async () => {
    // Limpiar mensajes de error
    document.querySelector("#edit_name-error").style.display = "none";
    document.querySelector("#edit_age-error").style.display = "none";
    document.querySelector("#edit_country-error").style.display = "none";

    let isValid = true;

    // Validar nombre
    const name = document.querySelector("#edit_name").value.trim();
    if (!name) {
        document.querySelector("#edit_name-error").style.display = "block";
        isValid = false;
    }

    // Validar edad
    const age = document.querySelector("#edit_age").value;
    if (!age || age <= 0) {
        document.querySelector("#edit_age-error").style.display = "block";
        isValid = false;
    }

    // Validar país
    const country = document.querySelector("#edit_country").value.trim();
    if (!country) {
        document.querySelector("#edit_country-error").style.display = "block";
        isValid = false;
    }

    // Si los datos no son válidos, detener el envío
    if (!isValid) {
        return;
    }

    // Si los datos son válidos, continuar con la solicitud
    const userId = document.querySelector("#id").value;
    try {
        const res = await fetch("php/update-data.php", {
            method: "POST",
            body: JSON.stringify({ "id": userId, "name": name, "age": age, "country": country }),
            headers: {
                "Content-Type": "application/json"
            }
        });
        const output = await res.json();

        if (output.success) {
            success.style.display = "flex";
            success.innerText = output.message;

            // Aquí puedes limpiar los campos si lo deseas
            document.querySelector("#edit_name").value = "";
            document.querySelector("#edit_age").value = "";
            document.querySelector("#edit_country").value = "";
            
            // Cerrar el modal
            document.querySelector("#update-user").style.display = "none"; // Cambia el display del modal a 'none'
            getUsers(); // Llama a tu función para refrescar la lista de usuarios
            getTotalCount(); // Llama a tu función para actualizar el conteo total

            setTimeout(() => {
                success.style.display = "none";
                success.innerText = "";
            }, 1000);
        } else {
            error.style.display = "flex";
            error.innerText = output.message;
            setTimeout(() => {
                error.style.display = "none";
                error.innerText = "";
            }, 1000);
        }
    } catch (error) {
        error.style.display = "flex";
        error.innerText = error.message;
        setTimeout(() => {
            error.style.display = "none";
            error.innerText = "";
        }, 1000);
    }
});

// Cerrar el modal al hacer clic en el botón de cerrar
document.querySelector("#update_close").addEventListener("click", () => {
    document.querySelector("#update-user").style.display = "none"; // Cambia el display del modal a 'none'
});

// delete user

// const deleteUser = async (id) => {
//     const res = await fetch("php/delete-data.php?id=" + id, {
//         method: "GET",
//     });
//     const output = await res.json();
//     if (output.success) {
//         success.style.display = "flex";
//         success.innerText = output.message;
//         setTimeout(() => {
//             success.style.display = "none";
//             success.innerText = "";
//         }, 1000)
//         getUsers();
//         getTotalCount();
//     } else {
//         error.style.display = "flex";
//         error.innerText = output.message;
//         setTimeout(() => {
//             error.style.display = "none";
//             error.innerText = "";
//         }, 1000)
//     }
// }

// Selecciona el modal de confirmación de eliminación
const confirmDeleteModal = document.getElementById("confirm-delete-modal");

// Función para abrir el modal de confirmación
function openConfirmDeleteModal(id) {
    userIdToDelete = id; // Asigna el ID del usuario a eliminar
    confirmDeleteModal.style.display = "flex"; // Muestra el modal
}

// Evento para cerrar el modal al hacer clic en Cancelar
document.querySelector("#cancel-delete").addEventListener("click", () => {
    confirmDeleteModal.style.display = "none"; // Cierra el modal
});


// Función para eliminar el usuario
document.querySelector("#confirm-delete").addEventListener("click", async () => {
    try {
        const res = await fetch("php/delete-data.php", {
            method: "DELETE",
            body: JSON.stringify({ id: userIdToDelete }), // Envía el ID en el cuerpo de la solicitud
            headers: {
                "Content-Type": "application/json"
            }
        });
        const output = await res.json();

        if (output.success) {
            alert(output.message); // Muestra un mensaje de éxito
            getUsers(); // Actualiza la lista de usuarios
        } else {
            alert(output.message); // Muestra un mensaje de error
        }
    } catch (error) {
        alert("Error al eliminar el usuario: " + error.message);
    } finally {
        document.querySelector("#confirm-delete-modal").style.display = "none"; // Cierra el modal
    }
});

// get total count  users;

const getTotalCount = async () => {
    let total = document.querySelector("#total");
    try {
        const res = await fetch("php/get-total-count.php", {
            method: "GET"
        });
        const output = await res.json();
        console.log("Output:", output); // Para verificar la estructura de la respuesta
        total.innerText = output.total_count;
    } catch (error) {
        console.error("Error:", error);
    }
};
getTotalCount();
import express from "express";
import cors from "cors";
import { MercadoPagoConfig, Preference } from 'mercadopago';
import nodemailer from 'nodemailer';
import mysql from 'mysql';

const client = new MercadoPagoConfig({ accessToken: 'TEST-8817196589918616-122312-f47e0d2b56e376c0235c1b5151729ed5-635992527' });

const app = express();
const port = 3000;

app.use(cors());
app.use(express.json());

// Configuración de nodemailer (ajusta según tu proveedor de correo)
const transporter = nodemailer.createTransport({
    host: 'smtp.gmail.com',
    port: 587,
    auth: {
        user: 'paginaswebs2002@gmail.com',
        pass: 'zyus ckyn gfaf ttnt'
    }

});

// Configuración de la conexión a la base de datos (ajusta según tu entorno)
const dbConnection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'comentariosphp',
});

dbConnection.connect();

app.get("/", (req, res) => {
    res.send("Soy el server");
});

app.post("/create_preference", async (req, res) => {
    try {
        const psychologistId = req.body.psychologistId;
        const userEmail = req.body.userEmail;

        // Consulta la base de datos para obtener los datos del psicólogo
        const query = `SELECT * FROM presentaciones WHERE id = ${psychologistId}`;
        dbConnection.query(query, (error, results, fields) => {
            if (error) {
                console.error('Error al obtener datos del psicólogo desde la base de datos:', error);
                res.status(500).json({
                    error: "Error al obtener datos del psicólogo desde la base de datos"
                });
            } else {
                // Verifica si se encontraron resultados
                if (results.length > 0) {
                    const psychologistInfo = results[0];

                    // Resto del código para crear la preferencia y enviar datos al frontend
                    const body = {
                        items: [
                            {
                                title: req.body.title,
                                quantity: Number(req.body.quantity),
                                unit_price: Number(req.body.price),
                                currency_id: "ARS",
                            },
                        ],
                        back_urls: {
                            success: `http://localhost/psiquiatriaapp/datos/datosProfesional.php?id=${psychologistId}`,
                            failure: "https://www.youtube.com/watch?v=JUXxxjRECRg&ab_channel=LAMEDIAB%C3%81VARA",
                            pending: "https://www.youtube.com/watch?v=JUXxxjRECRg&ab_channel=LAMEDIAB%C3%81VARA",
                        },
                        auto_return: "approved",
                        psychologistInfo: psychologistInfo,
                    };

                    const preference = new Preference(client);
                    preference.create({ body }).then(result => {
                        // Envía el ID de la preferencia y los datos del psicólogo al frontend
                        res.json({
                            id: result.id,
                            psychologistInfo: psychologistInfo,
                        });

                        // Envía un correo electrónico al usuario con los datos del psicólogo
                        sendEmailToUser(userEmail, psychologistInfo);

                        // Guarda el correo electrónico en la base de datos
                        saveUserEmail(userEmail, psychologistId);
                    }).catch(error => {
                        console.log('Error al crear la preferencia:', error);
                        res.status(500).json({
                            error: "Error al crear la preferencia :("
                        });
                    });
                } else {
                    console.error('No se encontraron datos del psicólogo con el ID proporcionado');
                    res.status(404).json({
                        error: "No se encontraron datos del psicólogo con el ID proporcionado"
                    });
                }
            }
        });
    } catch (error) {
        console.log(error);
        res.status(500).json({
            error: "Error al crear la preferencia :("
        });
    }
});

// Función para enviar correo electrónico
function sendEmailToUser(userEmail, psychologistInfo) {
    const mailOptions = {
        from: 'paginaswebs2002@gmail.com',
        to: userEmail,
        subject: 'Terapia Libre: informacion del profesional solicitado',
        html: `
            <h2>GRACIAS POR UTILIZAR NUESTRA PLATAFORMA DE SERVICIOS DE SALUD MENTAL “TERAPIA LIBRE”</h2>
            <p>TU PAGO HA SIDO ACREDITADO </p>
            <h2>Información del Profesional:</h2>
            <p>Nombre: ${psychologistInfo.nombre}</p>
            <p>telefono: ${psychologistInfo.telefono}</p>
            <p>Instagram</p>
            <p>Gmail</p>
            <p>¡GRACIAS POR SER PARTE DE TERAPIA LIBRE!
            —-
            TU OPINIÓN NOS IMPORTA.AGUARDAMOS TUS COMENTARIOS Y RECOMENDACIONES EN EL SIGUIENTE MAIL: QUEREMOSTUOPINION@TERAPIALIBRE.COM.AR </p>
        `,
    };

    transporter.sendMail(mailOptions, (error, info) => {
        if (error) {
            console.error('Error al enviar el correo electrónico:', error);
        } else {
            console.log('Correo electrónico enviado:', info.response);
        }
    });
}

// Función para guardar el correo electrónico en la base de datos
function saveUserEmail(userEmail, psychologistId) {
    const insertQuery = `INSERT INTO datos_usuario (user_email, psychologist_id) VALUES (?, ?)`;
    dbConnection.query(insertQuery, [userEmail, psychologistId], (error, results, fields) => {
        if (error) {
            console.error('Error al insertar el correo electrónico en la base de datos:', error);
        } else {
            console.log('Correo electrónico insertado en la base de datos');
        }
    });
}

app.listen(port, () => {
    console.log(`El servidor está corriendo en el puerto ${port}`);
});
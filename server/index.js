import express from "express";
import cors from "cors";
import { MercadoPagoConfig, Preference } from 'mercadopago';
import nodemailer from 'nodemailer';
import mysql from 'mysql';
import dotenv from 'dotenv';

dotenv.config();

const accessToken = process.env.ACCESS_TOKEN;

if (!accessToken) {
    console.error("No se encontró el accessToken en las variables de entorno.");
    process.exit(1);
}

const client = new MercadoPagoConfig({ accessToken });


const app = express();
const port = 3000;

app.use(cors());
app.use(express.json());

// Configuración de nodemailer
const transporter = nodemailer.createTransport({
    host: 'smtp.gmail.com',
    port: 587,
    auth: {
        user: 'paginaswebs2002@gmail.com',
        pass: 'zyus ckyn gfaf ttnt'
    }
});

// Configuración de la conexión a la base de datos
const dbConnection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'comentariosphp',
});

dbConnection.connect();

// Función para enviar correo electrónico
function sendEmailToUser(userEmail, psychologistInfo) {
    const mailOptions = {
        from: 'paginaswebs2002@gmail.com',
        to: userEmail,
        subject: 'Terapia Libre: información del profesional solicitado',
        html: `
            <h2>GRACIAS POR UTILIZAR NUESTRA PLATAFORMA DE SERVICIOS DE SALUD MENTAL “TERAPIA LIBRE”</h2>
            <p>TU PAGO HA SIDO ACREDITADO </p>
            <h2>Información del Profesional:</h2>
            <p>Nombre: ${psychologistInfo.nombre}</p>
            <p>Teléfono: ${psychologistInfo.telefono}</p>
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

// Manejar la creación de preferencias
// Manejar la creación de preferencias
app.post("/create_preference", async (req, res) => {
    try {
        const { psychologistId, userEmail, title, quantity, price } = req.body;

        const query = `SELECT * FROM presentaciones WHERE id = ${psychologistId}`;
        dbConnection.query(query, (error, results, fields) => {
            if (error) {
                console.error('Error al obtener datos del psicólogo desde la base de datos:', error);
                res.status(500).json({ error: "Error al obtener datos del psicólogo desde la base de datos" });
            } else {
                if (results.length > 0) {
                    const psychologistInfo = results[0];
                    const body = {
                        items: [{ title, quantity: Number(quantity), unit_price: Number(price), currency_id: "ARS" }],
                        back_urls: {
                            success: `http://localhost/psiquiatriaapp/datos/datosProfesional.php?id=${psychologistId}`,
                            failure: "http://localhost/psiquiatriaapp/psicologos/psicologosOnline.php#",
                            pending: "http://localhost/psiquiatriaapp/psicologos/psicologosOnline.php#",
                        },
                        auto_return: "approved",
                        psychologistInfo: psychologistInfo,
                    };

                    const preference = new Preference(client);
                    preference.create({ body }).then(result => {
                        res.json({ id: result.id, psychologistInfo });
                    }).catch(error => {
                        console.error('Error al crear la preferencia:', error);
                        res.status(500).json({ error: "Error al crear la preferencia :(" });
                    });
                } else {
                    console.error('No se encontraron datos del psicólogo con el ID proporcionado');
                    res.status(404).json({ error: "No se encontraron datos del psicólogo con el ID proporcionado" });
                }
            }
        });
    } catch (error) {
        console.log(error);
        res.status(500).json({ error: "Error al crear la preferencia :(" });
    }
});


// Manejar el webhook de pago exitoso
app.post("/webhook_pago_exitoso", (req, res) => {
    try {
        const { action, data } = req.body;

        if (action === 'payment' && data.status === 'approved') {
            const userEmail = data.payer.email;
            const psychologistId = data.metadata.psychologistId;

            const query = `SELECT * FROM presentaciones WHERE id = ${psychologistId}`;
            dbConnection.query(query, (error, results, fields) => {
                if (error) {
                    console.error('Error al obtener datos del psicólogo desde la base de datos:', error);
                } else {
                    if (results.length > 0) {
                        const psychologistInfo = results[0];
                        sendEmailToUser(userEmail, psychologistInfo);
                        saveUserEmail(userEmail, psychologistId);
                    } else {
                        console.error('No se encontraron datos del psicólogo con el ID proporcionado');
                    }
                }
            });
        }
    } catch (error) {
        console.error('Error en el webhook de pago exitoso:', error);
    }
    res.sendStatus(200);
});



app.listen(port, () => {
    console.log(`El servidor está corriendo en el puerto ${port}`);
});

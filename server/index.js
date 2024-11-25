const express = require("express");
const cors = require("cors");
const { MercadoPagoConfig, Preference } = require('mercadopago');
const nodemailer = require("nodemailer");
const mysql = require("mysql");
const bodyParser = require('body-parser');

const client = new MercadoPagoConfig({
    accessToken: process.env.MERCADOPAGO_ACCESS_TOKEN,
});

const app = express();
const port = 443;

app.use(cors());
app.use(express.json());
app.use(bodyParser.urlencoded({ extended: false }));

const dbConnection = mysql.createConnection({
    host: 'localhost',
    user: 'terapial_terapia',
    password: 'Wss1593.',
    database: 'terapial_terapia',
});

dbConnection.connect();

function generateUniqueId() {
    // Utiliza la fecha actual en milisegundos y un número aleatorio para crear un ID único
    const timestamp = Date.now().toString(36); // Convierte el tiempo actual en una cadena base-36
    const randomNumber = Math.floor(Math.random() * 1000000).toString(36); // Genera un número aleatorio y lo convierte en una cadena base-36
    return `${timestamp}-${randomNumber}`; // Combina ambas partes para crear un ID único
}

function generateVideoCallLink() {
    const sessionId = generateUniqueId(); // Genera un ID único
    return `https://meet.jit.si/${sessionId}`; // Crea el enlace de videollamada usando el ID generado
}

function sendEmailToUser(userEmail, psychologistInfo) {
    const transporter = nodemailer.createTransport({
        host: 'localhost',
        port: 25,
        auth: {
            user: 'terapialibre@terapialibre.com.ar',
            pass: 'abundancia2024'
        },
        tls: {
            rejectUnauthorized: false
        }
    });

    // Genera el enlace para la videollamada
    const videoCallLink = generateVideoCallLink();

    const userMailOptions = {
        from: 'terapialibre@terapialibre.com.ar',
        to: userEmail,
        subject: 'Terapia Libre: información del profesional solicitado',
        html: `
                <!DOCTYPE html>
                <html lang="es">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap">
                    <style>
                        body {
                            font-family: \'Montserrat\', sans-serif;
                            background-color: #e9ecef;
                            padding: 20px;
                            margin: 0;
                        }

                        .container {
                            max-width: 600px;
                            margin: 0 auto;
                            background-color: #ffffff;
                            border-radius: 8px;
                            padding: 20px;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                            border: 1px solid #ddd;
                        }

                        h2 {
                            color: #c1c700;
                            font-size: 24px;
                            margin-top: 0;
                        }

                        p {
                            color: #495057;
                            line-height: 1.6;
                            font-size: 16px;
                            margin: 10px 0;
                        }

                        .cta-button {
                            background-color: #c1c700;
                            color: #ffffff;
                            text-decoration: none;
                            padding: 12px 24px;
                            border-radius: 50px;
                            display: inline-block;
                            margin-top: 20px;
                            font-weight: 600;
                            text-align: center;
                            transition: background-color 0.3s ease;
                        }

                        .cta-button:hover {
                            background-color: #c1c700;
                            text-decoration: none;
                        }

                        a {
                            color: #007bff;
                            text-decoration: none;
                        }

                        a:hover {
                            text-decoration: underline;
                        }

                        .social-links a {
                            color: #007bff;
                            margin-right: 10px;
                        }
                    </style>
                </head>

                <body>
                    <div class="container">
                        <h2>¡Gracias por utilizar nuestra plataforma de servicios de salud mental “Terapia Libre”!</h2>
                        <p>Nos complace informarte que tu pago ha sido acreditado exitosamente.</p>
                        
                        <h2>Información del Profesional:</h2>
                        <p><strong>Nombre:</strong> ${psychologistInfo.nombre}</p>
                        <p><i class="fas fa-phone" style="color: #a3a000;"></i><strong>Teléfono:</strong> ${psychologistInfo.telefono}</p>
                        <p><i class="fab fa-instagram" style="color: #a3a000;"></i><strong>Instagram:</strong> <a href="${psychologistInfo.instagram}">Instagram</a></p>
                        <p><strong>Correo Electrónico:</strong> ${psychologistInfo.mail}</p>

                        <h2>Enlace para la Videollamada:</h2>
                        <p>Tu enlace para la videollamada es: <a href="${videoCallLink}" target="_blank">${videoCallLink}</a></p>

                        <p>¡Gracias por ser parte de Terapia Libre!</p>
                        <p>Tu opinión es muy importante para nosotros. Agradecemos tus comentarios y recomendaciones <a href="mailto:queremostuopinion@terapialibre.com.ar">aquí</a>.</p>

                        <a href="https://www.terapialibre.com.ar" class="cta-button">Explora más en nuestro sitio web</a>
                    </div>
                </body>

                </html>
        `,
    };

    // Obtener el correo electrónico del psicólogo desde psychologistInfo
    const psychologistEmail = psychologistInfo.mail;

    const psychologistMailOptions = {
        from: 'terapialibre@terapialibre.com.ar',
        to: psychologistEmail,
        subject: 'Tienes un nuevo paciente',
        html: `
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap">
            <style>
                body {
                    font-family: \'Montserrat\', sans-serif;
                    background-color: #e9ecef;
                    padding: 20px;
                    margin: 0;
                }

                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                    border-radius: 8px;
                    padding: 20px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                    border: 1px solid #ddd;
                }

                h2 {
                    color: #c1c700;
                    font-size: 24px;
                    margin-top: 0;
                }

                p {
                    color: #495057;
                    line-height: 1.6;
                    font-size: 16px;
                    margin: 10px 0;
                }

                .cta-button {
                    background-color: #c1c700;
                    color: #ffffff;
                    text-decoration: none;
                    padding: 12px 24px;
                    border-radius: 50px;
                    display: inline-block;
                    margin-top: 20px;
                    font-weight: 600;
                    text-align: center;
                    transition: background-color 0.3s ease;
                }

                .cta-button:hover {
                    background-color: #c1c700;
                    text-decoration: none;
                }

                a {
                    color: #007bff;
                    text-decoration: none;
                }

                a:hover {
                    text-decoration: underline;
                }

                .social-links a {
                    color: #007bff;
                    margin-right: 10px;
                }
            </style>
        </head>

        <body>
            <div class="container">
                <h2>¡Nuevo Paciente Asignado!</h2>
                <p>Hola ${psychologistInfo.nombre},</p>
                <p>Has sido asignado como el psicólogo de un nuevo paciente en Terapia Libre.</p>

                <h2>Información del Paciente:</h2>
                <p><strong>Correo Electrónico:</strong> ${userEmail}</p>

                <h2>Enlace para la Videollamada:</h2>
                <p>Tu enlace para la videollamada es: <a href="${videoCallLink}" target="_blank">${videoCallLink}</a></p>

                <p>Por favor, revisa los detalles del paciente y prepárate para la primera sesión. Si tienes alguna pregunta o necesitas más información, no dudes en ponerte en contacto con nosotros.</p>

                <p>¡Gracias por tu colaboración y dedicación!</p>
                
            </div>
        </body>

        </html>`
    };

    transporter.sendMail(userMailOptions, (error, info) => {
        if (error) {
            console.error('Error al enviar el correo electrónico al usuario:', error);
            console.log('Error details:', error.stack);
        } else {
            console.log('Correo electrónico enviado al usuario:', info.response);
        }
    });

    transporter.sendMail(psychologistMailOptions, (error, info) => {
        if (error) {
            console.error('Error al enviar el correo electrónico al psicólogo:', error);
            console.log('Error details:', error.stack);
        } else {
            console.log('Correo electrónico enviado al psicólogo:', info.response);
        }
    });
}


function saveUserEmail(user, psychologistReferenceId, paymentId) {
    // Primero, buscar el id_usuario en la tabla `presentaciones` usando el psychologistReferenceId
    const searchQuery = `SELECT id_usuario FROM presentaciones WHERE id = ?`;

    dbConnection.query(searchQuery, [psychologistReferenceId], (error, results) => {
        if (error) {
            console.error('Error al buscar id_usuario en la tabla presentaciones:', error);
            return;
        }

        // Verificar si se encontró un id_usuario
        if (results.length > 0) {
            const psychologistId = results[0].id_usuario;

            // Insertar en la tabla `datos_usuario` con el id_usuario obtenido
            const insertQuery = `INSERT INTO datos_usuario (user, psychologist_id, payment_id) VALUES (?, ?, ?)`;

            dbConnection.query(insertQuery, [user, psychologistId, paymentId], (insertError, insertResults) => {
                if (insertError) {
                    console.error('Error al insertar los datos de usuario en la base de datos:', insertError);
                } else {
                    console.log('Correo electrónico insertado en la base de datos');
                }
            });
        } else {
            console.error('No se encontró el usuario en la tabla presentaciones con el psychologistReferenceId proporcionado.');
        }
    });
}




app.post("/create_preference", async (req, res) => {
    try {
        const { psychologistId, userId, title, quantity, price } = req.body;
        const idempotencyKey = req.headers['x-idempotency-key'];
        const query = `SELECT * FROM presentaciones WHERE id = ${psychologistId}`;
        dbConnection.query(query, (error, results, fields) => {
            if (error) {
                console.error('Error al obtener datos del psicólogo desde la base de datos:', error);
                res.status(500).json({ error: "Error al obtener datos del psicólogo desde la base de datos" });
            } else {
                if (results.length > 0) {
                    const psychologistInfo = results[0];
                    // Concatenar `userId` y `psychologistId` en `external_reference`
                    const externalReference = `${userId},${psychologistId}`;
                    const body = {
                        items: [{ title, quantity: Number(quantity), unit_price: Number(price), currency_id: "ARS" }],
                        back_urls: {
                            success: `https://terapialibre.com.ar/usuario/dashboard/dashboard.php`,
                            failure: "https://terapialibre.com.ar/psicologos/psicologosOnline.php#",
                            pending: "https://terapialibre.com.ar/psicologos/psicologosOnline.php#",
                        },
                        auto_return: "approved",
                        psychologistInfo: psychologistInfo,
                        notification_url: 'https://terapialibre.com.ar/webhook',
                        external_reference: externalReference // Agrega aquí si lo necesitas en el webhook
                    };

                    const preference = new Preference(client);
                    preference.create({ body, idempotencyKey }).then(result => {

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

app.post("/webhook", async function (req, res) {
    const paymentId = req.query.id;

    try {
        const response = await fetch(`https://api.mercadopago.com/v1/payments/${paymentId}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${client.accessToken}`
            }
        });
        if (response.ok) {
            const paymentData = await response.json();
            if (paymentData.status === 'approved') {
                const userEmail = paymentData.payer.email;

                // Descomponer external_reference para obtener userId y psychologistId
                const [userId, psychologistId] = paymentData.external_reference.split(',');

                console.log('User ID:', userId);  // Verifica si userId tiene un valor
                console.log('Psychologist ID:', psychologistId);  // Verifica si psychologistId tiene un valor

                const psychologistQuery = `SELECT * FROM presentaciones WHERE id = ?`;
                dbConnection.query(psychologistQuery, [psychologistId], (error, results, fields) => {
                    if (error) {
                        console.error('Error al obtener datos del psicólogo desde la base de datos:', error);
                    } else {
                        if (results.length > 0) {
                            const psychologistInfo = results[0];
                            saveUserEmail(userId, psychologistId, paymentId);
                            console.log(`Enviando correo a: ${userEmail}`);
                            sendEmailToUser(userEmail, psychologistInfo);
                        } else {
                            console.error('No se encontraron datos del psicólogo con el ID proporcionado');
                            console.log(psychologistId);
                        }
                    }
                });
            }
        }
        res.sendStatus(200);
    } catch (error) {
        console.error('Error:', error);
        res.sendStatus(500);
    }
});




app.listen(port, () => {
    console.log(`El servidor está corriendo en el puerto ${port}`);
});
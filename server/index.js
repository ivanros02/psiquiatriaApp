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

function sendEmailToUser(userEmail, psychologistInfo) {
    const transporter = nodemailer.createTransport({
        host: 'localhost',
        port: 25,
        auth: {
            user: 'terapialibre@terapialibre.com.ar',
            pass: 'Argentina2024'
        },
        tls: {
            rejectUnauthorized: false
        }
    });

    const userMailOptions = {
        from: 'terapialibre@terapialibre.com.ar',
        to: userEmail,
        subject: 'Terapia Libre: información del profesional solicitado',
        html: `
            <h2>GRACIAS POR UTILIZAR NUESTRA PLATAFORMA DE SERVICIOS DE SALUD MENTAL “TERAPIA LIBRE”</h2>
            <p>TU PAGO HA SIDO ACREDITADO </p>
            <h2>Información del Profesional:</h2>
            <p>Nombre: ${psychologistInfo.nombre}</p>
            <p>Teléfono: ${psychologistInfo.telefono}</p>
            <p>Instagram: ${psychologistInfo.instagram}</p>
            <p>Mail: ${psychologistInfo.mail}</p>
            <p>¡GRACIAS POR SER PARTE DE TERAPIA LIBRE!
            —-
            TU OPINIÓN NOS IMPORTA.AGUARDAMOS TUS COMENTARIOS Y RECOMENDACIONES EN EL SIGUIENTE MAIL: QUEREMOSTUOPINION@TERAPIALIBRE.COM.AR </p>
        `,
    };

    // Obtener el correo electrónico del psicólogo desde psychologistInfo
    const psychologistEmail = psychologistInfo.mail;

    const psychologistMailOptions = {
        from: 'terapialibre@terapialibre.com.ar',
        to: psychologistEmail,
        subject: 'Tienes un nuevo paciente',
        text: 'Has sido asignado como el psicólogo de un nuevo paciente en Terapia Libre.'
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


function saveUserEmail(userEmail, psychologistId, paymentId) {
    const insertQuery = `INSERT INTO datos_usuario (user_email, psychologist_id, payment_id) VALUES (?, ?, ?)`;
    dbConnection.query(insertQuery, [userEmail, psychologistId, paymentId], (error, results, fields) => {
        if (error) {
            console.error('Error al insertar el correo electrónico en la base de datos:', error);
        } else {
            console.log('Correo electrónico insertado en la base de datos');
        }
    });
}

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
                            success: `https://terapialibre.com.ar/datos/datosProfesional.php?id=${psychologistId}`,
                            failure: "https://terapialibre.com.ar/psicologos/psicologosOnline.php#",
                            pending: "https://terapialibre.com.ar/psicologos/psicologosOnline.php#",
                        },
                        auto_return: "approved",
                        psychologistInfo: psychologistInfo,
                        notification_url: 'https://terapialibre.com.ar/webhook',
                        external_reference: psychologistId,
                    };

                    const preference = new Preference(client);
                    preference.create({ body }).then(result => {
                        const paymentId = result.id;
                        console.log("Payment ID:", paymentId);
                        saveUserEmail(userEmail, psychologistId, paymentId);
                        res.json({ id: paymentId, psychologistInfo });
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
        const psychologistId = paymentData.external_reference;
        const psychologistQuery = `SELECT * FROM presentaciones WHERE id = ?`;
        dbConnection.query(psychologistQuery, [psychologistId], (error, results, fields) => {
          if (error) {
            console.error('Error al obtener datos del psicólogo desde la base de datos:', error);
          } else {
            if (results.length > 0) {
              const psychologistInfo = results[0];
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

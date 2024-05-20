import { createTransport } from 'nodemailer';

// Configuración del transportador (SMTP)
let transporter = createTransport({
    service: 'Gmail',
    auth: {
        user: 'ivanrosendo1102@gmail.com',
        pass: 'zvyv yzss gsrp oprw'
    }
});

// Definir el correo electrónico a enviar
let mailOptions = {
    from: 'ivanrosendo1102@gmail.com',
    to: 'ivanrosendo1102@gmail.com',
    subject: 'Terapia Libre: información del profesional solicitado',
        html: `
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    padding: 20px;
                }
                .container {
                    background-color: #f3f3f3;
                    border-radius: 10px;
                    padding: 20px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    align-items: center;
                    text-align: center;
                }
                h2 {
                    color: #000;
                }
                p {
                    color: #000;
                }
                .cta-button {
                    background-color: #c1c700;
                    color: #fff;
                    text-decoration: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                    display: inline-block;
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h2>¡Gracias por utilizar nuestra plataforma de servicios de salud mental “Terapia Libre”!</h2>
                <p>Tu pago ha sido acreditado.</p>
                <h2>Información del Profesional:</h2>
                <p><strong>Nombre:</strong> 'Ivan'</p>
                <p><strong>Teléfono:</strong> '123'</p>
                <p><strong>Instagram:</strong> 'ig'</p>
                <p><strong>Mail:</strong> 'mail'</p>
                <p>¡Gracias por ser parte de Terapia Libre!</p>
                <p>Tu opinión nos importa. Agradecemos tus comentarios y recomendaciones <a href="mailto:queremostuopinion@terapialibre.com.ar">aquí</a>.</p>
                <a href="https://www.terapialibre.com.ar" class="cta-button">Explora más en nuestro sitio web</a>
            </div>
        </body>
        </html>`,
};

// Enviar el correo electrónico
transporter.sendMail(mailOptions, (error, info) => {
    if (error) {
        console.log('Error al enviar el correo electrónico:', error);
    } else {
        console.log('Correo electrónico enviado:', info.response);
    }
});

import {SwaggerUIBundle} from 'swagger-ui-dist';
import 'swagger-ui/dist/swagger-ui.css';

SwaggerUIBundle({
    url: '/openapi',
    dom_id: '#swagger-api',
    presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIBundle.SwaggerUIStandalonePreset,
    ],
});

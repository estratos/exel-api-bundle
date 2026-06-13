# Exel API Bundle

Bundle Symfony para integración con la API de Exel del Norte.

## Características

- Compatible con Symfony 7.4+
- Compatible con PHP 8.3+
- Autowiring y Autoconfiguration
- Cliente HTTP basado en Symfony HttpClient
- DTOs tipados
- Caché configurable
- Retry automático para errores temporales
- Logging PSR-3
- Excepciones tipadas
- Arquitectura desacoplada
- Distribuible mediante Composer
- Preparado para futuras versiones de la API

---

# Instalación

```bash
composer require exeldelnorte/exel-api-bundle
```

---

# Configuración

Crear el archivo:

```yaml
# config/packages/exel_api.yaml

exel_api:
    api_key: '%env(EXEL_API_KEY)%'
    base_url: 'https://api01.exeldelnorte.com.mx'
```

Agregar la variable de entorno:

```env
EXEL_API_KEY=xxxxxxxxxxxxxxxxxxxxxxxx
```

---

# Estructura del Bundle

```text
exel-api-bundle/
│
├── composer.json
├── README.md
│
├── src/
│   ├── ExelApiBundle.php
│   │
│   ├── DependencyInjection/
│   │   ├── ExelApiExtension.php
│   │   └── Configuration.php
│   │
│   ├── Client/
│   │   └── ExelApiClient.php
│   │
│   ├── Service/
│   │   ├── ProductService.php
│   │   ├── OrderService.php
│   │   └── ShippingService.php
│   │
│   ├── DTO/
│   │   ├── Product.php
│   │   ├── Inventory.php
│   │   ├── TechnicalSheet.php
│   │   ├── Brand.php
│   │   ├── Family.php
│   │   └── Order.php
│   │
│   ├── Exception/
│   │   ├── ApiException.php
│   │   ├── AuthenticationException.php
│   │   ├── ValidationException.php
│   │   └── NotFoundException.php
│   │
│   ├── Event/
│   │   ├── ProductFetchedEvent.php
│   │   ├── OrderCreatedEvent.php
│   │   └── OrderConfirmedEvent.php
│   │
│   └── Resources/
│       └── config/
│           └── services.yaml
│
└── tests/
```

---

# Servicios Disponibles

## ExelApi

Servicio principal del Bundle.

```php
use Exel\ApiBundle\ExelApi;

public function __construct(
    private ExelApi $exel
) {
}
```

---

# Productos

## Obtener productos

```php
$products = $this->exel
    ->products()
    ->all();
```

---

## Obtener producto por SKU

```php
$product = $this->exel
    ->products()
    ->getBySku('ABC123');
```

---

## Obtener múltiples SKU

```php
$products = $this->exel
    ->products()
    ->getBySkus([
        'ABC123',
        'DEF456',
        'GHI789'
    ]);
```

---

## Obtener inventario

```php
$inventory = $this->exel
    ->products()
    ->inventory([
        'ABC123',
        'DEF456'
    ]);
```

---

## Obtener ficha técnica

```php
$technicalSheet = $this->exel
    ->products()
    ->technicalSheet('ABC123');
```

---

## Obtener imágenes

```php
$images = $this->exel
    ->products()
    ->images('ABC123');
```

---

# Catálogos

## Marcas

```php
$brands = $this->exel
    ->catalogs()
    ->brands();
```

---

## Familias

```php
$families = $this->exel
    ->catalogs()
    ->families();
```

---

## Subcategorías

```php
$subcategories = $this->exel
    ->catalogs()
    ->subcategories();
```

---

# Pedidos

## Crear pedido

```php
$order = $this->exel
    ->orders()
    ->create([
        'cliente' => [],
        'direccion' => [],
        'productos' => []
    ]);
```

---

## Consultar pedido

```php
$order = $this->exel
    ->orders()
    ->get('123456');
```

---

## Confirmar preorden

```php
$response = $this->exel
    ->orders()
    ->confirm('123456');
```

---

# Logística

## Obtener cotización de flete

```php
$quote = $this->exel
    ->shipping()
    ->quote([
        'codigo_postal' => '31100',
        'productos' => []
    ]);
```

---

## Registrar guía

```php
$response = $this->exel
    ->shipping()
    ->registerGuide([
        'orden' => '123456',
        'guia' => 'TRACK123'
    ]);
```

---

# DTOs

Todos los resultados se devuelven como objetos tipados.

Ejemplo:

```php
$product->getSku();

$product->getDescription();

$product->getBrand();

$product->getStock();

$product->getPrice();

$product->getImageUrl();
```

---

# Caché

Los siguientes recursos pueden almacenarse en caché:

- Marcas
- Familias
- Subcategorías
- Fichas técnicas

Configuración:

```yaml
exel_api:
    cache:
        enabled: true
        ttl: 3600
```

---

# Retry Automático

Reintenta solicitudes fallidas por errores temporales.

Configuración:

```yaml
exel_api:
    retry:
        enabled: true
        max_retries: 3
        delay_ms: 1000
```

---

# Logging

Compatible con cualquier implementación PSR-3.

Eventos registrados:

- Request
- Response
- Error
- Retry
- Timeout

Configuración:

```yaml
exel_api:
    logging:
        enabled: true
```

---

# Eventos

## ProductFetchedEvent

```php
#[AsEventListener]
public function onProductFetched(
    ProductFetchedEvent $event
): void {

}
```

---

## OrderCreatedEvent

```php
#[AsEventListener]
public function onOrderCreated(
    OrderCreatedEvent $event
): void {

}
```

---

## OrderConfirmedEvent

```php
#[AsEventListener]
public function onOrderConfirmed(
    OrderConfirmedEvent $event
): void {

}
```

---

# Manejo de Excepciones

```php
use Exel\ApiBundle\Exception\ApiException;

try {

    $products = $this->exel
        ->products()
        ->all();

} catch (ApiException $e) {

}
```

Excepciones disponibles:

- ApiException
- AuthenticationException
- ValidationException
- NotFoundException

---

# Ejemplo Completo

```php
namespace App\Command;

use Exel\ApiBundle\ExelApi;
use Symfony\Component\Console\Command\Command;

class SyncProductsCommand extends Command
{
    public function __construct(
        private ExelApi $exel
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {

        $products = $this->exel
            ->products()
            ->all();

        foreach ($products as $product) {

            $output->writeln(
                sprintf(
                    '%s - %s',
                    $product->getSku(),
                    $product->getDescription()
                )
            );
        }

        return Command::SUCCESS;
    }
}
```

---

# Requisitos

- PHP 8.3+
- Symfony 7.4+
- Extensión JSON
- Extensión OpenSSL

---

# Roadmap

## v1.0

- Cliente API
- Productos
- Inventario
- Pedidos
- Fletes
- DTOs
- Cache
- Retry
- Logging

## v1.1

- Serializer avanzado
- Paginación automática
- Batch requests

## v2.0

- Compatibilidad con futuras versiones de API
- Soporte para Webhooks
- Métricas y observabilidad

---

# Licencia

Propietaria.

Copyright © Exel del Norte.

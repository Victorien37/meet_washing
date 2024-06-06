# API Documentation

## Routes

#### Base URL
`/api/vehicule`

### 1. Create a Vehicle

#### Endpoint
`POST /`

#### Parameters
- `numberplate` (string, required): Vehicle's number plate.
- `circulation_date` (string, required): Vehicle's circulation date.
- `vehicule_type` (string, required): Vehicle type categorie or name :
```
    A or mini citadine,
    B or citadine,
    C or compacte,
    D or familiale,
    F or luxe,
    J or suv,
    M or monospace,
    S or sport
```
- `images` (array of files, optional): Vehicle images.

#### Responses
- `201 Created`:
```
{
    data: {
        id: int,
        numberplate: string,
        circulation_date: string,
        vehicule_type: {
            id: int,
            category: string,
            name: string
        },
        images: [
            {
                id: int,
                url: string,
                alt: string?,
            },
        ]
    },
    message: string
}
```
- `400 Bad Request`: If the provided parameters are invalid.
- `500 Internal Server Error`: If an error occurs during vehicle creation.

### 2. Get a Vehicle

#### Route
`GET /{id}`

#### Parameters
- `id` (int or string, required): Vehicle ID or number plate.

#### Responses
- `200 OK`:
```
{
    data: {
        id: int,
        numberplate: string,
        circulation_date: string,
        vehicule_type: {
            id: int,
            category: string,
            name: string
        },
        images: [
            {
                id: int,
                url: string,
                alt: string?,
            },
        ]
    },
    message: string
}
```
- `404 Not Found`: If the vehicle is not found.

### 3. Update a Vehicle

#### Route
`PUT /{id}`

#### Informations
All old images linked with vehicule will be removed

#### Parameters
- `id` (int or string, required): Vehicle ID or number plate.
- `images` (array of files, optional): New vehicle images.

#### Responses
- `200 OK`:
```
{
    data: {
        id: int,
        numberplate: string,
        circulation_date: string,
        vehicule_type: {
            id: int,
            category: string,
            name: string
        },
        images: [
            {
                id: int,
                url: string,
                alt: string?,
            },
        ]
    },
    message: string
}
```
- `404 Not Found`: If the vehicle is not found.
- `500 Internal Server Error`: If an error occurs during vehicle update.

### 4. Delete a Vehicle

#### Route
`DELETE /{id}`

#### Parameters
- `id` (int or string, required): Vehicle ID or number plate.

#### Responses
- `204 No Content`: If the vehicle is deleted successfully.
- `404 Not Found`: If the vehicle is not found.
- `500 Internal Server Error`: If an error occurs during vehicle deletion.
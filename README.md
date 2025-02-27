# AIRO Ltd. Full-Stack Developer Task

This project is a **Laravel 12 + Vue.js** application for a **quotation system**.  
It includes **JWT authentication**, API endpoints, and a frontend form to collect user input, fetch quotations, and display results.

---

## 🚀 Features
- **Laravel 12 Backend** with API endpoints.
- **Vue.js 3 Frontend** with Vue Router & Pinia.
- **JWT Authentication** using `tymon/jwt-auth`.
- **Quotation API** calculating prices based on age & trip length.
- **Validation** for age, currency, and date range.
- **Tailwind CSS** for responsive design.
- **Unit Tests** for validation and pricing logic.

---

## 🛠 Installation Steps

### **1️⃣ Clone the Repository**
```bash
git clone https://github.com/your-repo/airo-quotation.git
cd airo-quotation


## Usage

| Command            | Meaning                                            |
|--------------------|----------------------------------------------------|
| `make local-setup` | setup local environment in one step for first time |
| `make test`        | run unitTest                                       | 
| `make ecs`         | run cs-fixer                                       |
| `make phpstan`     | run php-stan                                       |
| `make rector`      | run rector                                         |
| `make ci`          | run all Quality tools  
| `make start`       | start docker sail                                  |
| `make stop`        | stop docker                                        |
| `make rebuild`     | rebuild without cache                              |
| `make restart`     | restart docker                                     |
| `make migrate`     | run migration                                      |
| `make clear`       | clear cache                                        |


    

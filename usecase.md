```mermaid
usecaseDiagram
actor Superadmin as SA
actor Admin as A
actor Coordinator as C
actor Staff as S
actor Medical as M
actor Partner as P
actor Patient as PT
```

SA --> (CRUD User Role)
SA --> (CRUD Pedukuhan)
SA --> (CRUD Posyandu)
SA --> (CRUD Schedule)
SA --> (CRUD Gallery)
SA --> (CRUD Patient)
SA --> (CRUD Article)
SA --> (CRUD MedicalRecord)
SA --> (Accepted MedicalRecord

A --> (CRUD User Role)
A --> (CRUD Pedukuhan)
A --> (CRUD Posyandu)
A --> (CRUD Schedule)
A --> (CRUD Gallery)
A --> (CRUD Patient)
A --> (CRUD Article)
A --> (CRUD MedicalRecord)
A --> (Accepted MedicalRecord)

C --> (CRUD User Role)
C --> (CRUD Schedule)
C --> (CRUD Gallery)
C --> (CRUD Patient)
C --> (CRUD Article)
C --> (CRUD MedicalRecord)
C --> (Accepted MedicalRecord)

S --> (CRUD Patient)
S --> (CRUD MedicalRecord)
S --> (Read Pedukuhan)
S --> (Read Posyandu)
S --> (Read Schedule)
S --> (Read Gallery)
S --> (Read Article)

M --> (CRUD Patient)
M --> (CRUD MedicalRecord)
M --> (Read Pedukuhan)
M --> (Read Posyandu)
M --> (Read Schedule)

P --> (Read Pedukuhan)
P --> (Read Posyandu)
P --> (Read Schedule)
P --> (Read Gallery)
P --> (Read Patient)
P --> (Read Article)
P --> (Read MedicalRecord)

PT --> (CRUD Patient)
PT --> (Read Pedukuhan)
PT --> (Read Posyandu)
PT --> (Read Schedule)
PT --> (Read Gallery)
PT --> (Read Article)
PT --> (Read MedicalRecord)

```

```

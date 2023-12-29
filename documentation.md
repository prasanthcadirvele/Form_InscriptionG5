1. User Class
   
    Attributes:

   - id: The unique identifier for each user. 
   - email: The email address of the user.
   - password: The hashed password of the user.
   - firstName: The first name of the user.
   - lastName: The last name of the user.
   - isValidated: Indicates whether the user account is validated.
   - token: A token associated with the user.
   - tokenExpiresAt: The expiration date and time for the token.

    Methods:

        getId(): Returns the user's ID.
        getEmail(): Returns the user's email address.
        getPassword(): Returns the user's hashed password.
        getFirstName(): Returns the user's first name.
        getLastName(): Returns the user's last name.
        getIsValidated(): Returns whether the user account is validated.
        getToken(): Returns the user's token.
        getTokenExpiresAt(): Returns the expiration date and time for the user's token.
        setId($id): Sets the user's ID.
        setEmail($email): Sets the user's email address.
        setPassword($password): Sets the user's hashed password.
        setFirstName($firstName): Sets the user's first name.
        setLastName($lastName): Sets the user's last name.
        setIsValidated($isValidated): Sets whether the user account is validated.
        setToken($token): Sets the user's token.
        setTokenExpiresAt($tokenExpiresAt): Sets the expiration date and time for the user's token.

2. Enseignant Class (extends User)
   
    Attributes:

    - user_type: The user type, set to 'enseignant'.
    - etablissement: The educational institution associated with the teacher.
    - registrations: A collection of registrations associated with the teacher.

    Relationships:

        ManyToOne with Etablissement: Each teacher belongs to one educational institution.
        OneToMany with Registration: Each teacher can have multiple registrations.

3. Etablissement Class
   
    Attributes:

   - id: The unique identifier for each educational institution.
   - uai: The UAI (Unité Administrative Immatriculée) code of the institution.
   - etablissementName: The name of the educational institution.
   - etablissementType: The type of the educational institution.
   - etablissementAdress: The address of the educational institution.
   - etablissementDepartement: The department of the educational institution.
   - etablissementCodePostal: The postal code of the educational institution.
   - enseignants: A collection of teachers associated with the institution.

    Relationships:

         OneToMany with Enseignant: Each educational institution can have multiple teachers.

4. GroupeTesteurs Class
   
    Attributes:

    - id: The unique identifier for each test group.
    - groupTesteurLabel: The label or name of the test group.
    - groupTesteurDescription: The description of the test group.
    - createdAt: The date and time when the test group was created.
    - registrations: A collection of registrations associated with the test group.

Relationships:

    OneToMany with Registration: Each test group can have multiple registrations.

5. Registration Class
   
    Attributes:

   - id: The unique identifier for each registration.
   - groupeTesteurs: The test group associated with the registration.
   - enseignant: The teacher associated with the registration.
   - registrationDate: The date when the registration occurred.
   - isRegistrationValidated: Indicates whether the registration is validated.

    Relationships:

        ManyToOne with GroupeTesteurs: Each registration belongs to one test group.
        ManyToOne with Enseignant: Each registration belongs to one teacher.

These classes represent a system where teachers (Enseignant) are associated with educational institutions (Etablissement), participate in test groups (GroupeTesteurs), and have registrations linking them to specific test groups. The User class serves as the base class for Enseignant, providing common attributes and methods.

EnseignantController
Purpose:

This controller handles the management of Enseignant entities, which represent teachers. It provides endpoints for creating, updating, deleting, and retrieving teacher information.
Methods:

    createEnseignant
        Endpoint: /enseignant/
        Method: POST
        Description: Creates a new teacher and associates them with a specific Etablissement (educational institution).

    setPassword
        Endpoint: /enseignant/set-password/{token}
        Method: POST
        Description: Sets the password for a teacher based on a unique token. The method is intended for use during the teacher registration process.

    showEnseignant
        Endpoint: /enseignant/{id}
        Method: GET
        Description: Retrieves information about a specific teacher by ID.

    listEnseignants
        Endpoint: /enseignant/list
        Method: GET
        Description: Retrieves a list of all teachers.

    updateEnseignant
        Endpoint: /enseignant/update/{id}
        Method: PUT
        Description: Updates information for a specific teacher by ID.

    deleteEnseignant
        Endpoint: /enseignant/delete/{id}
        Method: DELETE
        Description: Deletes a teacher by ID.

    validateEnseignant
        Endpoint: /enseignant/{id}/validate
        Method: PATCH
        Description: Validates (activates) a teacher by changing their validation status.

    getEnseignantsBySchoolId
        Endpoint: /enseignant/etablissement/id/{schoolId}
        Method: GET
        Description: Retrieves a list of teachers associated with a specific Etablissement by its ID.

    getEnseignantsByUai
        Endpoint: /enseignant/etablissement/uai/{uai}
        Method: GET
        Description: Retrieves a list of teachers associated with a specific Etablissement by its UAI (Unité Administrative Immatriculée).

EtablissementController
Purpose:

This controller manages Etablissement entities, representing educational institutions. It provides endpoints for creating, updating, deleting, and retrieving information about educational institutions.
Methods:

    getAllEtablissements
        Endpoint: /etablissement/list
        Method: GET
        Description: Retrieves a list of all educational institutions.

    getEtablissementById
        Endpoint: /etablissement/id/{id}
        Method: GET
        Description: Retrieves information about a specific educational institution by ID.

    getEtablissementByUAI
        Endpoint: /etablissement/uai/{uai}
        Method: GET
        Description: Retrieves information about a specific educational institution by its UAI.

    getEtablissementsByCodePostal
        Endpoint: /etablissement/list/cp/{codePostal}
        Method: GET
        Description: Retrieves a list of educational institutions based on a specific postal code.

    getEtablissementsByDepartement
        Endpoint: /etablissement/list/dept/{departement}
        Method: GET
        Description: Retrieves a list of educational institutions based on a specific department.

    getEtablissementsByType
        Endpoint: /etablissement/list/type/{type}
        Method: GET
        Description: Retrieves a list of educational institutions based on a specific type.

    createEtablissement
        Endpoint: /etablissement/
        Method: POST
        Description: Creates a new educational institution.

    updateEtablissement
        Endpoint: /etablissement/{id}
        Method: PUT
        Description: Updates information about a specific educational institution by ID.

    deleteEtablissement
        Endpoint: /etablissement/{id}
        Method: DELETE
        Description: Deletes an educational institution by ID.

GroupeTesteursController
Purpose:

This controller manages GroupeTesteurs entities, which represent groups of testers. It provides endpoints for creating, updating, deleting, and retrieving information about tester groups.
Methods:

    getAllGroupeTesteurs
        Endpoint: /groupeTesteurs/list
        Method: GET
        Description: Retrieves a list of all tester groups.

    getGroupeTesteursById
        Endpoint: /groupeTesteurs/id/{id}
        Method: GET
        Description: Retrieves information about a specific tester group by ID.

    createGroupeTesteurs
        Endpoint: /groupeTesteurs/
        Method: POST
        Description: Creates a new tester group.

    updateGroupeTesteurs
        Endpoint: /groupeTesteurs/id/{id}
        Method: PUT
        Description: Updates information about a specific tester group by ID.

    deleteGroupeTesteurs
        Endpoint: /groupeTesteurs/id/{id}
        Method: DELETE
        Description: Deletes a tester group by ID.

RegistrationController
Purpose:

This controller manages Registration entities, representing the registration of teachers in tester groups. It provides endpoints for creating, deleting, and validating teacher registrations.
Methods:

    getRegistrationsByGroupeTesteurId
        Endpoint: /registration/groupe-testeur/{groupeTesteurId}
        Method: GET
        Description: Retrieves a list of teacher registrations for a specific tester group.

    getRegistrationsByEnseignantId
        Endpoint: /registration/enseignant/{enseignantId}
        Method: GET
        Description: Retrieves a list of teacher registrations for a specific teacher.

    createRegistration
        Endpoint: /registration/
        Method: POST
        Description: Creates a new teacher registration for a specific tester group.

    deleteRegistration
        Endpoint: /registration/id/{id}
        Method: DELETE
        Description: Deletes a teacher registration by ID.

    validateRegistration
        Endpoint: /registration/validate/{id}
        Method: POST
        Description: Validates (activates) a teacher registration by ID.

Now, let's discuss the relationships between these classes:

    An Enseignant (teacher) can be associated with an Etablissement (educational institution).
    An Etablissement has a collection of Enseignants associated with it.
    A GroupeTesteurs (tester group) represents a group of testers.
    An Enseignant can be registered in a GroupeTesteurs.
    A GroupeTesteurs has a collection of Enseignants registered in it.
    A Registration represents the registration of an Enseignant in a GroupeTesteurs.
    A GroupeTesteurs has a collection of Registrations associated with it.
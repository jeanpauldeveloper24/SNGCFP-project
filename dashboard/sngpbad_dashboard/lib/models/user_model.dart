enum UserRole {
  badRepresentative,
  ministryOfTutelle,
  nationalDirection,
  externalAuditor,
  prestataire;

  // Le label est rattaché à chaque valeur de l'enum
  String get label {
    switch (this) {
      case UserRole.badRepresentative: return "Représentant de la BAD";
      case UserRole.ministryOfTutelle: return "Ministère de tutelle";
      case UserRole.nationalDirection: return "Direction nationale";
      case UserRole.externalAuditor: return "Auditeur externe";
      case UserRole.prestataire: return "Prestataire / Entreprise";
    }
  }
}

class UserModel {
  final String email;
  final String password;
  final String name;
  final UserRole role;

  UserModel({
    required this.email,
    required this.password,
    required this.name,
    required this.role,
  });

  // On simplifie le getter pour utiliser celui de l'enum
  String get roleLabel => role.label;
}
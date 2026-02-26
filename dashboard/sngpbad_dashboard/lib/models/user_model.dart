class UserModel {
  final int id; 
  final String email;
  final String name;
  final String roleName; 
  final String? phone;
  final String? photo;

  UserModel({
    required this.id,
    required this.email,
    required this.name,
    required this.roleName,
    this.phone,
    this.photo,
  });

  // Pour garder tes labels jolis dans l'interface Flutter
  String get roleLabel {
    switch (roleName) {
      case 'badRepresentative': return "Représentant de la BAD";
      case 'ministryOfTutelle': return "Ministère de tutelle";
      case 'nationalDirection': return "Direction nationale";
      case 'externalAuditor': return "Auditeur externe";
      case 'prestataire': return "Prestataire / Entreprise";
      case 'ADMIN': return "Administrateur";
      default: return roleName; // Affiche le nom brut si inconnu
    }
  }

  factory UserModel.fromJson(Map<String, dynamic> json) {
  return UserModel(
    id: json['id'] ?? 0,
    email: json['email'] ?? '',
    name: json['name'] ?? '',
    // On extrait le nom depuis l'objet role envoyé par Laravel
    roleName: (json['role'] != null) ? json['role']['name'] : 'Inconnu', 
    phone: json['phone'],
    photo: json['photo'],
  );
}
}
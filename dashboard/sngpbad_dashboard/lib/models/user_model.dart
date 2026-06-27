class UserModel {
  final String id;
  final String name;
  final String email;
  final String password;
  final String phone;
  final String photo; // Contient la chaîne Base64
  final String status;
  final String created_by;
  final DateTime? last_connection;
  final DateTime? created_at;
  final DateTime? updated_at;

  // Détails du rôle (extraits de l'objet imbriqué)
  final String roleName;        // ex: "badRepresentative", "ORDONNATEUR"
  final String roleDescription; // La description associée
  final String platform;        // flutter_desktop ou laravel_web

  UserModel({
    required this.id,
    required this.name,
    required this.email,
    required this.password,
    required this.phone,
    required this.photo,
    required this.status,
    required this.created_by,
    this.last_connection,
    this.created_at,
    this.updated_at,
    required this.roleName,
    required this.roleDescription,
    required this.platform,
  });

  /// Usine pour créer un UserModel à partir du JSON Firebase
  factory UserModel.fromJson(String id, Map<String, dynamic> json) {
    // 1. Extraction de l'objet 'role'
    final Map<String, dynamic> roleMap = json['role'] ?? {};
    
    // 2. Identification de la clé du rôle (ex: "badRepresentative")
    // On cherche la première clé qui n'est pas nulle
    String rName = roleMap.keys.isNotEmpty ? roleMap.keys.first : "UNKNOWN";
    
    // 3. Extraction des détails à l'intérieur de cette clé
    final Map<String, dynamic> roleDetails = roleMap[rName] is Map 
        ? roleMap[rName] 
        : {};

    return UserModel(
      id: id,
      name: json['name'] ?? '',
      email: json['email'] ?? '',
      password: json['password'] ?? '',
      phone: json['phone'] ?? '',
      photo: json['photo'] ?? '',
      status: json['status'] ?? 'actif',
      created_by: json['created_by'] ?? '',
      last_connection: json['last_connection'] != null 
          ? DateTime.tryParse(json['last_connection'].toString()) 
          : null,
      created_at: json['created_at'] != null 
          ? DateTime.tryParse(json['created_at'].toString()) 
          : null,
      updated_at: json['updated_at'] != null 
          ? DateTime.tryParse(json['updated_at'].toString()) 
          : null,
      roleName: rName,
      roleDescription: roleDetails['description'] ?? '',
      platform: roleDetails['platform'] ?? '',
    );
  }

  /// Conversion de l'objet en JSON pour l'envoi vers Firebase
  Map<String, dynamic> toJson() {
    return {
      'name': name,
      'email': email,
      'password': password,
      'phone': phone,
      'photo': photo,
      'status': status,
      'created_by': created_by,
      'last_connection': last_connection?.toIso8601String(),
      'created_at': created_at?.toIso8601String(),
      'updated_at': updated_at?.toIso8601String(),
      'role': {
        roleName: {
          'description': roleDescription,
          'platform': platform,
        }
      },
    };
  }

  /// Création d'une copie avec un ID mis à jour après l'inscription
  UserModel copyWith({
    String? id,
    String? name,
    String? email,
    String? photo,
    String? roleName, required String password,
  }) {
    return UserModel(
      id: id ?? this.id,
      name: name ?? this.name,
      email: email ?? this.email,
      password: this.password,
      phone: this.phone,
      photo: photo ?? this.photo,
      status: this.status,
      created_by: this.created_by,
      last_connection: this.last_connection,
      created_at: this.created_at,
      updated_at: this.updated_at,
      roleName: roleName ?? this.roleName,
      roleDescription: this.roleDescription,
      platform: this.platform,
    );
  }
}
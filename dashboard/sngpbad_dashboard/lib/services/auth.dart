import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:hashlib/hashlib.dart'; 
import 'package:secure_session/secure_session.dart'; 
import 'package:sngpbad_dashboard/models/user_model.dart';

class AuthService {
  static const String baseUrl = "https://sngcfp-default-rtdb.firebaseio.com";
  static const String authSecret = "YPA4oS4yVcgTGR5F3HUBP8ZQWYMH8mww8BTJYCB4";
  
  late SecureSession _secureSession;

  AuthService() {
    _secureSession = SecureSession(options: [
      SessionOptions(
        cookieName: 'sngp_session',
        defaultSessionName: 'session',
        expiry: const Duration(days: 7),
        // La clé doit faire exactement 16 caractères pour être valide
        secret: 'SNGBAD_2026_PROT', 
      ),
    ]);
    _secureSession.init([]); 
  }

  /// SOLUTION DE DERNIER RECOURS : Fonction globale sha256sum
  String _hashPassword(String data) {
    return sha256sum(data).toString();
  }

  // Connexion d'un utilisateur déjà inscrit
  Future<UserModel?> login(String email, String password) async {
    try {
      final String cleanEmail = email.trim().toLowerCase();
      
      // OPTIMISATION CRUCIALE : On filtre directement par email via l'API REST de Firebase
      // Cela évite de télécharger toute la table des utilisateurs.
      final String filterUrl = '$baseUrl/users.json?auth=$authSecret&orderBy="email"&equalTo="$cleanEmail"';
      
      final response = await http.get(Uri.parse(filterUrl));

      if (response.statusCode == 200) {
        final Map<String, dynamic>? users = jsonDecode(response.body);
        
        // Si aucun utilisateur ne correspond à cet email
        if (users == null || users.isEmpty) {
          print("❌ Aucun utilisateur trouvé avec cet email.");
          return null;
        }

        // Firebase renvoie un dictionnaire avec l'identifiant unique (ID) en clé
        String foundId = users.keys.first;
        Map<String, dynamic> userData = Map<String, dynamic>.from(users[foundId]);
        
        // Hachage du mot de passe saisi pour comparaison
        String hashedInput = _hashPassword(password);

        // Vérification du mot de passe
        if (userData['password']?.toString() == hashedInput) {
          final user = UserModel.fromJson(foundId, userData);
          
          // Sécurité additionnelle : Seuls les rôles Flutter Desktop passent
          if (user.platform != "flutter_desktop") {
            print("🚫 Accès refusé : Cette plateforme n'est pas autorisée pour votre rôle.");
            return null;
          }

          // Initialisation de la session sécurisée
          _secureSession.write(foundId, 'user_session_id');
          _secureSession.write(user.roleName, 'user_role');
          _secureSession.write('true', 'is_logged_in');

          print("✅ Session active pour : ${user.name}");
          return user;
        } else {
          print("❌ Mot de passe incorrect.");
        }
      }
      return null;
    } catch (e) {
      print("Erreur Login: $e");
      return null;
    }
  }

  // Création d'un utilisateur
  Future<String?> register(UserModel user) async {
    try {
      // 1. On génère le hash SHA-256 du mot de passe en clair
      String hashedPassword = _hashPassword(user.password);
      
      // 2. On nettoie l'email (minuscules et sans espaces) pour éviter les erreurs de frappe
      String cleanEmail = user.email.trim().toLowerCase();
      
      // 3. CRUCIAL : On crée une COPIE de l'utilisateur avec le mot de passe haché et l'email propre
      final securedUser = user.copyWith(
        password: hashedPassword,
        email: cleanEmail
      );

      print("🚀 Envoi Firebase (Mot de passe haché) : ${securedUser.email}");

      final response = await http.post(
        Uri.parse("$baseUrl/users.json?auth=$authSecret"),
        body: json.encode(securedUser.toJson()),
      );

      if (response.statusCode == 200) {
        print("✅ Inscription réussie dans la base de données.");
        return json.decode(response.body)['name'];
      }
      return null;
    } catch (e) {
      print("💥 Erreur lors de l'inscription : $e");
      return null;
    }
  }

  Future<UserModel?> getConnectedUser() async {
    final String? id = _secureSession.read('user_session_id');
    if (id != null && id.isNotEmpty) {
      final response = await http.get(
        Uri.parse("$baseUrl/users/$id.json?auth=$authSecret")
      );
      if (response.statusCode == 200 && response.body != 'null') {
        return UserModel.fromJson(id, json.decode(response.body));
      }
    }
    return null;
  }

  Future<void> logout() async {
    _secureSession.write('', 'user_session_id');
    _secureSession.write('', 'is_logged_in');
    print("👋 Session terminée.");
  }
}
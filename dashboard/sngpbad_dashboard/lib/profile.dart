import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:sngpbad_dashboard/services/auth.dart';

class Profile extends StatefulWidget {
  const Profile({super.key});

  @override
  State<Profile> createState() => _ProfileState();
}

class _ProfileState extends State<Profile> {
  final _formKey = GlobalKey<FormState>();
  final AuthService _authService = AuthService(); // Instance du service
  
  late TextEditingController _nameController;
  late TextEditingController _emailController;
  late TextEditingController _phoneController;
  
  int? _userId; 
  bool _isLoading = true;
  bool _isSaving = false;
  String? _roleLabel;
  String? _photoUrl;

  @override
  void initState() {
    super.initState();
    _loadInitialData();
  }

  Future<void> _loadInitialData() async {
    // Utilisation de la méthode statique que tu as déjà
    final data = await AuthService.getStoredUser();
    
    setState(() {
      _userId = data['id']; 
      _nameController = TextEditingController(text: data['name']);
      _emailController = TextEditingController(text: data['email']);
      _phoneController = TextEditingController(text: data['phone'] ?? "");
      _roleLabel = data['role_name'] ?? "Partenaire SNGP";
      _photoUrl = data['photo'];
      _isLoading = false;
    });
  }

  // J'ai enlevé le paramètre dynamic authService qui créait une erreur
  Future<void> _updateProfile() async {
    if (_formKey.currentState!.validate()) {
      setState(() => _isSaving = true);
      
      // Appel de ta méthode avec les bons arguments
      final success = await _authService.updateUser(
        _userId!,
        _nameController.text,
        _phoneController.text,
      );
      
      if (mounted) {
        setState(() => _isSaving = false);
        if (success) {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              content: Text("Profil mis à jour avec succès"), 
              backgroundColor: Colors.green,
              behavior: SnackBarBehavior.floating,
            ),
          );
        } else {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              content: Text("Erreur lors de la mise à jour côté serveur"), 
              backgroundColor: Colors.red,
              behavior: SnackBarBehavior.floating,
            ),
          );
        }
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    final Color primaryBlue = const Color(0xFF1B4F72);

    if (_isLoading) return const Center(child: CircularProgressIndicator());

    return Scaffold(
      backgroundColor: const Color(0xFFF4F7F6),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(40),
        child: Center(
          child: Container(
            constraints: const BoxConstraints(maxWidth: 600),
            padding: const EdgeInsets.all(30),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(20),
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(0.05), 
                  blurRadius: 20, 
                  offset: const Offset(0, 10)
                )
              ],
            ),
            child: Form(
              key: _formKey,
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  _buildHeader(primaryBlue),
                  const Divider(height: 40),
                  _buildLabel("Nom Complet"),
                  _buildTextField(_nameController, Icons.person_outline),
                  const SizedBox(height: 20),
                  _buildLabel("Email Professionnel (Non modifiable)"),
                  _buildTextField(_emailController, Icons.email_outlined, enabled: false),
                  const SizedBox(height: 20),
                  _buildLabel("Numéro de Téléphone"),
                  _buildTextField(_phoneController, Icons.phone_android_outlined),
                  const SizedBox(height: 40),
                  _buildActionButtons(primaryBlue),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildHeader(Color color) {
    return Row(
      children: [
        CircleAvatar(
          radius: 45,
          backgroundColor: color.withOpacity(0.1),
          backgroundImage: _photoUrl != null ? NetworkImage(_photoUrl!) : null,
          child: _photoUrl == null 
              ? Icon(Icons.account_circle, size: 50, color: color) 
              : null,
        ),
        const SizedBox(width: 25),
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text("Paramètres du Compte", 
                style: GoogleFonts.montserrat(fontSize: 22, fontWeight: FontWeight.bold, color: color)),
              const SizedBox(height: 5),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                decoration: BoxDecoration(
                  color: Colors.green.withOpacity(0.1),
                  borderRadius: BorderRadius.circular(5),
                ),
                child: Text("RÔLE : ${_roleLabel?.toUpperCase()}", 
                  style: const TextStyle(color: Colors.green, fontWeight: FontWeight.bold, fontSize: 11)),
              ),
            ],
          ),
        )
      ],
    );
  }

  Widget _buildLabel(String text) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8.0),
      child: Text(text, style: GoogleFonts.inter(fontWeight: FontWeight.w600, color: Colors.grey[800], fontSize: 14)),
    );
  }

  Widget _buildTextField(TextEditingController controller, IconData icon, {bool enabled = true}) {
    return TextFormField(
      controller: controller,
      enabled: enabled,
      style: GoogleFonts.inter(color: enabled ? Colors.black87 : Colors.grey[600]),
      decoration: InputDecoration(
        prefixIcon: Icon(icon, color: const Color(0xFF1B4F72), size: 20),
        filled: !enabled,
        fillColor: enabled ? Colors.transparent : Colors.grey[100],
        contentPadding: const EdgeInsets.symmetric(vertical: 18),
        border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
        enabledBorder: OutlineInputBorder(borderSide: BorderSide(color: Colors.grey[300]!), borderRadius: BorderRadius.circular(12)),
        focusedBorder: OutlineInputBorder(borderSide: const BorderSide(color: Color(0xFF1B4F72), width: 2), borderRadius: BorderRadius.circular(12)),
      ),
      validator: (v) => (v == null || v.isEmpty) ? "Ce champ est requis" : null,
    );
  }

  Widget _buildActionButtons(Color color) {
    return SizedBox(
      width: double.infinity,
      child: ElevatedButton(
        // Correction ici : On appelle simplement la méthode locale
        onPressed: _isSaving ? null : _updateProfile,
        style: ElevatedButton.styleFrom(
          backgroundColor: color,
          foregroundColor: Colors.white,
          padding: const EdgeInsets.symmetric(vertical: 22),
          elevation: 0,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
        ),
        child: _isSaving 
          ? const SizedBox(height: 20, width: 20, child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2))
          : Text("ENREGISTRER LES MODIFICATIONS", style: GoogleFonts.inter(fontWeight: FontWeight.bold, letterSpacing: 1)),
      ),
    );
  }
}
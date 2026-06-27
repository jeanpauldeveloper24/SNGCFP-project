import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:sngpbad_dashboard/models/user_model.dart';
import 'package:sngpbad_dashboard/routes.dart';

class AppDrawer extends StatelessWidget {
  final UserModel user;
  final Function(String) onSectionSelected;

  const AppDrawer({super.key, required this.user, required this.onSectionSelected});

  final Color primaryBlue = const Color(0xFF1B4F72);
  final Color errorRed = const Color(0xFFE74C3C);

  @override
  Widget build(BuildContext context) {
    return Container(
      width: 280,
      color: primaryBlue,
      child: Column(
        children: [
          _buildLogoSection(),
          Expanded(
            child: ListView(
              padding: EdgeInsets.zero,
              children: [
                _buildMenuItem(icon: Icons.home_outlined, title: "Accueil", sectionId: AppRoutes.accueil, context: context),
                _buildMenuItem(icon: Icons.person_outline, title: "Mon Profil", sectionId: AppRoutes.profile, context: context),                
                const Divider(color: Colors.white24, indent: 20, endIndent: 20),

                // MENUS DYNAMIQUES BASÉS SUR LE RÔLE
                ..._buildDynamicMenus(context),
                
                const Divider(color: Colors.white24, indent: 20, endIndent: 20),
                _buildMenuItem(icon: Icons.settings_outlined, title: "Paramètres", sectionId: AppRoutes.settings, context: context),
              ],
            ),
          ),
          const Divider(color: Colors.white24),
          _buildMenuItem(icon: Icons.logout, title: "Déconnexion", sectionId: AppRoutes.login, isLogout: true, context: context),
          _buildFooter(),
        ],
      ),
    );
  }

  List<Widget> _buildDynamicMenus(BuildContext context) {
    List<Widget> menus = [];

    // Les statistiques sont masquées uniquement pour les auditeurs externes
    if ( user.roleName != 'auditeur externe') {
      menus.add(_buildMenuItem(icon: Icons.analytics_outlined, title: "Statistiques", sectionId: AppRoutes.statistiques, context: context));
    }

    switch (user.roleName.toLowerCase().trim()) {
      case 'representant bad':
        menus.addAll([
          _buildMenuItem(icon: Icons.account_balance_wallet_outlined, title: "Liste des projets", sectionId: AppRoutes.projetlist, context: context),
          _buildMenuItem(icon: Icons.assignment_outlined, title: "Flux financiers", sectionId: AppRoutes.fluxfinanciers, context: context),
          _buildMenuItem(icon: Icons.assignment_outlined, title: "Suivis des marchés", sectionId: AppRoutes.marche, context: context),
          _buildMenuItem(icon: Icons.assignment_outlined, title: "Pistes d'audits", sectionId: AppRoutes.pistesAudits, context: context),
          _buildMenuItem(icon: Icons.warning_amber_rounded, title: "Alertes & Risques", sectionId: AppRoutes.alertes, context: context),
        ]);
        break;

      case 'ministre':
        menus.addAll([
          _buildMenuItem(icon: Icons.description_outlined, title: "Liste des projets", sectionId: AppRoutes.projetlist, context: context),
          _buildMenuItem(icon: Icons.warning_amber_rounded, title: "Alertes & Risques", sectionId: AppRoutes.alertes, context: context),
        ]);
        break;

      case 'national direction':
        menus.addAll([
          _buildMenuItem(icon: Icons.gavel_rounded, title: "Passation des Marchés", sectionId: AppRoutes.passationMarches, context: context),
          _buildMenuItem(icon: Icons.track_changes_outlined, title: "Liste des projets", sectionId: AppRoutes.projetlist, context: context),
          _buildMenuItem(icon: Icons.assignment_outlined, title: "Performances sectorielles", sectionId: AppRoutes.perfSectorielles, context: context),
          _buildMenuItem(icon: Icons.assignment_outlined, title: "Suivis des marchés", sectionId: AppRoutes.marche, context: context),
          _buildMenuItem(icon: Icons.assignment_outlined, title: "Suivis des chantiers", sectionId: AppRoutes.suiviChantiers, context: context),
          _buildMenuItem(icon: Icons.warning_amber_rounded, title: "Alertes & Risques", sectionId: AppRoutes.alertes, context: context),
        ]);
        break;

      case 'auditeur externe':
        menus.addAll([
          _buildMenuItem(icon: Icons.fact_check_outlined, title: "Audit & Conformité", sectionId: AppRoutes.auditConformite, context: context),
          _buildMenuItem(icon: Icons.folder_shared_outlined, title: "Liste des projets", sectionId: AppRoutes.projetlist, context: context),
          
          // TIROIR COMPTABILITÉ SPÉCIFIQUE (LES 5 PILIERS)
          _buildExpansionMenuItem(
            icon: Icons.account_balance_wallet_outlined,
            title: "Comptabilité Spécifique",
            context: context,
            children: [
              _buildSubMenuItem(title: "Comptabilité Financière", sectionId: AppRoutes.comptaFinanciere, context: context),
              _buildSubMenuItem(title: "Comptabilité de Gestion & Coûts", sectionId: AppRoutes.comptaGestion, context: context),
              _buildSubMenuItem(title: "Comptabilité de l'Actif", sectionId: AppRoutes.comptaActif, context: context),
              _buildSubMenuItem(title: "Comptabilité de Caisse", sectionId: AppRoutes.comptaCaisse, context: context),
              _buildSubMenuItem(title: "Marchés Monétaires & Devises", sectionId: AppRoutes.comptaMonetaire, context: context),
            ],
          ),

          _buildMenuItem(icon: Icons.assignment_outlined, title: "Liste des marchés", sectionId: AppRoutes.marche, context: context),
          _buildMenuItem(icon: Icons.assignment_outlined, title: "Liste des paiements", sectionId: AppRoutes.listePaiements, context: context),
          _buildMenuItem(icon: Icons.assignment_outlined, title: "Rapports des travaux", sectionId: AppRoutes.rapportsTravaux, context: context),
        ]);
        break;

      case 'prestataire':
        menus.addAll([
          _buildMenuItem(icon: Icons.construction_rounded, title: "Rapport des Travaux", sectionId: AppRoutes.rapportsTravaux, context: context),
          _buildMenuItem(icon: Icons.payments_outlined, title: "Demande de paiement", sectionId: AppRoutes.demandePaiement, context: context),
          _buildMenuItem(icon: Icons.assignment_outlined, title: "Lancer des alertes", sectionId: AppRoutes.lancerAlertes, context: context),
        ]);
        break;
    }
    return menus;
  }

  Widget _buildMenuItem({
    required IconData icon, 
    required String title, 
    required String sectionId, 
    bool isLogout = false, 
    bool hasNotification = false, 
    required BuildContext context
  }) {
    return ListTile(
      leading: Icon(icon, color: isLogout ? errorRed : Colors.white70, size: 22),
      title: Text(
        title, 
        style: GoogleFonts.inter(
          color: isLogout ? errorRed : Colors.white, 
          fontSize: 13,
          fontWeight: isLogout ? FontWeight.bold : FontWeight.normal,
        )
      ),
      trailing: hasNotification 
          ? Container(width: 8, height: 8, decoration: const BoxDecoration(color: Colors.orange, shape: BoxShape.circle))
          : null,
      onTap: () => isLogout 
          ? Navigator.pushReplacementNamed(context, AppRoutes.login) 
          : onSectionSelected(sectionId),
    );
  }

  // Nouveau widget pour gérer l'arborescence imbriquée (ExpansionTile)
  Widget _buildExpansionMenuItem({
    required IconData icon,
    required String title,
    required BuildContext context,
    required List<Widget> children,
  }) {
    return ExpansionTile(
      leading: Icon(icon, color: Colors.white70, size: 22),
      title: Text(
        title,
        style: GoogleFonts.inter(color: Colors.white, fontSize: 13),
      ),
      iconColor: Colors.white70,
      collapsedIconColor: Colors.white43,
      childrenPadding: const EdgeInsets.only(left: 12),
      children: children,
    );
  }

  // Nouveau widget pour les sous-menus de l'arborescence
  Widget _buildSubMenuItem({
    required String title,
    required String sectionId,
    required BuildContext context,
  }) {
    return ListTile(
      dense: true,
      contentPadding: const EdgeInsets.symmetric(horizontal: 24, vertical: 0),
      title: Text(
        title,
        style: GoogleFonts.inter(color: Colors.white60, fontSize: 12),
      ),
      trailing: const Icon(Icons.arrow_right_alt_rounded, color: Colors.white24, size: 16),
      onTap: () => onSectionSelected(sectionId),
    );
  }

  Widget _buildLogoSection() {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 40),
      child: Column(
        children: [
          Container(
            padding: const EdgeInsets.all(10),
            decoration: BoxDecoration(
              color: Colors.white, 
              borderRadius: BorderRadius.circular(8),
              boxShadow: const [BoxShadow(color: Colors.black12, blurRadius: 4)]
            ),
            child: Text(
              "LOGO BAD", 
              style: TextStyle(fontWeight: FontWeight.bold, color: primaryBlue, fontSize: 12)
            ),
          ),
          const SizedBox(height: 15),
          Text(
            "SNGCFP-project", 
            style: GoogleFonts.montserrat(
              color: Colors.white, 
              fontSize: 18, 
              fontWeight: FontWeight.bold,
              letterSpacing: 1.2
            )
          ),
        ],
      ),
    );
  }

  Widget _buildFooter() {
    return const Padding(
      padding: EdgeInsets.all(20),
      child: Text(
        "v1.0.0", 
        style: TextStyle(color: Colors.white24, fontSize: 10)
      ),
    );
  }
}